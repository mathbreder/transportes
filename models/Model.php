<?php
require_once '../functions.php';

class Model
{
  protected static $dao;

  /**
   * Get all objects
   * @return array
   */
  public static function getAll()
  {
    return call_user_func(static::$dao . '::getAll');
  }

  /**
   * Get an object by id
   * @param $id
   * @return mixed
   */
  public static function getById($id)
  {
    return call_user_func(static::$dao . '::getById', $id);
  }

  /**
   * Get all objects with pagination
   * @return mixed
   */
  public static function getPage($page = 1, $records_per_page = 5)
  {
    return call_user_func(static::$dao . '::getPage', $page, $records_per_page);
  }

  /**
   * Create an object
   * @param $data
   */
  public function create(): void
  {
    call_user_func(static::$dao . '::create', $this);
  }

  /**
   * Update an object
   * @param $data
   */
  public function update(): void
  {
    call_user_func(static::$dao . '::update', $this);
  }

  /**
   * Delete an object
   * @param $data
   */
  public function delete(): void
  {
    call_user_func(static::$dao . '::delete', $this);
  }

  /**
   * Redirect to a page
   * @param $message
   * @param $page
   */
  public static function redirect($message, $path = '', $status = 'success'): void
  {
    $path = set_base_url() . $path;
    $_SESSION['message'] = $message;
    $_SESSION['status'] = $status;
    header("Location: $path");
    exit();
  }

  /**
   * Redirect to a page with error message
   * @param $message
   * @param $page
   */
  public static function error($message, $path = ""): void
  {
    $path = set_base_url() . $path;
    $_SESSION["message"] = $message;
    $_SESSION["status"] = "danger";
    header("Location: $path");
    exit();
  }
}
