<?php
include_once '../db_connect.php';

class DAO
{
  const WHERE_ID = ' WHERE id = :id';

  private static string $table;
  private static array $fields;
  private static array $attributes;
  private static array $transformations;

  /**
   * Get all records from the database table
   */
  public static function getAll()
  {
    $pdo  = pdoConnectMysql();
    $sql  = 'SELECT * FROM ' . static::$table . ' ORDER BY id desc';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Get all records from a page
   * @param int $page
   * @param int $records_per_page
   * @return array
   */
  public static function getPage($page = 1, $records_per_page = 5)
  {
    $pdo  = pdoConnectMysql();
    $sql  = 'SELECT * FROM ' . static::$table . ' ORDER BY id desc LIMIT :current_page, :record_per_page';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':current_page', ($page - 1) * $records_per_page, PDO::PARAM_INT);
    $stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Get an record by id
   * @param $id
   * @return mixed
   */
  public static function getById($id)
  {
    $pdo  = pdoConnectMysql();
    $sql  = 'SELECT * FROM ' . static::$table . static::WHERE_ID;
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  /**
   * Get number of total records in the database table
   * @return int
   */
  public static function getTotal()
  {
    $pdo  = pdoConnectMysql();
    $sql  = 'SELECT COUNT(*) AS total FROM ' . static::$table;
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'];
  }

  /**
   * Create a new record
   * @param $data
   * @return string
   */
  public static function create($data)
  {
    $pdo  = pdoConnectMysql();
    $sql  = 'INSERT INTO ' . static::$table . ' (' . implode(',', static::$fields) . ') VALUES (:' . implode(', :', static::$fields) . ')';
    $stmt = $pdo->prepare($sql);
    $preparedData = static::applyDbTransformations($data);
    foreach (static::$attributes as $attribute => $field) {
      $stmt->bindValue(':' . $field, $preparedData->$attribute);
    }
    $stmt->execute();
    return $pdo->lastInsertId();
  }

  /**
   * Update a record
   * @param $data
   * @return int
   */ 
  public static function update($data)
  {
    $pdo  = pdoConnectMysql();
    $sql  = 'UPDATE ' . static::$table . ' SET ';
    foreach (static::$fields as $field) {
      $sql .= $field . ' = :' . $field . ',';
    }
    $sql = substr($sql, 0, -1);
    $sql .= static::WHERE_ID;
    $stmt = $pdo->prepare($sql);
    $preparedData = static::applyDbTransformations((array) $data);
    foreach (static::$attributes as $attribute => $field) {
      $stmt->bindValue(':' . $field, $preparedData[$attribute]);
    }
    $stmt->execute();
    return $stmt->rowCount();
  }

  /**
   * Delete a record
   * @param $id
   * @return int
   */
  public static function delete($data)
  {
    $pdo  = pdoConnectMysql();
    $sql  = 'DELETE FROM ' . static::$table . static::WHERE_ID;
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $data->id);
    $stmt->execute();
    return $stmt->rowCount();
  }

  /**
   * Convert an array to an object
   * @param $data
   * @return array
   */
  public static function toObject($data)
  {
    $result = [];
    foreach ($data as $key => $value) {
      $values = array_values(static::$attributes);
      if (in_array($key, $values)) {
        $keyIndex = array_search($key, $values);
        $newKey = array_keys(static::$attributes)[$keyIndex];
        $result[$newKey] = $value;
        continue;
      }
      $result[$key] = $value;
    }
    return $result;
  }

  /**
   * Apply transformations to an object
   * @param $object
   * @return array
   */
  public static function applyTransformations($object)
  {
    foreach (static::$attributes as $attribute => $value) {
      if (array_key_exists($value, static::$transformations)) {
        $method = static::$transformations[$value][0];
        $object[$attribute] = static::$method($object[$attribute]);
      }
    }
    return $object;
  }

  /**
   * Apply transformations to prepare data to be saved in the database
   */
  public static function applyDbTransformations($object)
  {
    foreach (static::$attributes as $attribute => $value) {
      if (array_key_exists($value, static::$transformations)) {
        $method = static::$transformations[$value][1];
        is_object($object) ? $object->$attribute = static::$method($object->$attribute) : $object[$attribute] = static::$method($object[$attribute]);
      }
    }
    return $object;
  }
}
