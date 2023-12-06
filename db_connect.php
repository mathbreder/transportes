<?php
function pdoConnectMysql()
{
  $databaseHost = 'localhost';
  $databaseUser = 'root';
  $databasePass = '';
  $databaseName = 'transportes';
  $databaseString = 'mysql:host=' . $databaseHost . ';dbname=' . $databaseName . ';charset=utf8mb4';
  try {
    $pdo = new PDO(
      $databaseString,
      $databaseUser,
      $databasePass
    );
    $sql = file_get_contents(__DIR__ . '/db.sql');
    $pdo->exec($sql);
    return $pdo;
  } catch (PDOException $exception) {
    // If there is an error with the connection, stop the script and display the error.
    exit('Failed to connect to database!');
  } catch (Exception $exception) {
    exit('Failed to connect to database!');
  }
}
