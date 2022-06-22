<?php

/**
 * Database Class
 */
class Database
{

  private $host;
  private $username;
  private $password;
  public $conn;

  function __construct($host, $username, $password) {
    $this->host = $host;
    $this->username = $username;
    $this->password = $password;
    // Create Connection
    $this->conn = new PDO("mysql:host=$this->host", $this->username, $this->password);
  }

  /* Use Database -
    Checks if database with that name exists or not,
    if not than it creates one and uses it.
  */
  public function useDB($dbName) {
    $sql = "USE $dbName";
    $sql = $this->conn->prepare($sql);
    if (!($sql->execute())) {
      $this->createDB($dbName);
      $sql->execute();
    }
  }

  /* Insert to Table -
    Insert the values with columns name to the
    specified table and also make sure all values
    are safe before inserting.
  */
  public function insertTbl($table, $columns, $values) {
    $sql = "INSERT INTO `$table` (".implode(', ', $columns).")
            VALUES (:".implode(', :', $columns).")";
    $sql = $this->conn->prepare($sql);
    foreach ($columns as $key => $value) {
      $sql->bindParam(":$columns[$key]", $values[$key]);
    }
    if ($sql->execute()) {
      return $this->conn->lastInsertId();
    } else {
      return $sql->errorinfo();
    }
  }

  /* Update Columns -
    Update the values with columns name to the
    specified table and also make sure all values
    are safe before inserting wuth multiple conditions.
  */
  public function updateWhere($table, $values, $where) {
    foreach ($values as $key => $value)
      $columns[] = "`$key` = '$value'";
    $sql = "UPDATE `$table` SET ".implode(', ', $columns)." WHERE ".$where."";
    $sql = $this->conn->prepare($sql);
    $sql->execute();
  }

  /* Delete Columns -
    delete the values with specified
    table wuth multiple conditions.
  */
  public function deleteWhere($table, $where) {
    $sql = "DELETE FROM `$table` WHERE ".$where."";
    $sql = $this->conn->prepare($sql);
    $sql->execute();
  }

  /* Select from Table -
    selects all values from the all
    columns from the specified table.
  */
  public function selectAll($table) {
    $sql = "SELECT * FROM `$table`";
    $sql = $this->conn->prepare($sql);
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
  }

  /* Select with condition -
    selects all values from
    all these columns from the specified
    table where your conditions satisfies.
  */
  public function selectAllWhere($table, $where) {
    $sql = "SELECT * FROM `$table` WHERE $where";
    $sql = $this->conn->prepare($sql);
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
  }

  /* ID Value -
    selects id value from
    the foreign table id falls.
  */
  public function idValue($table, $column, $id) {
    $sql = "SELECT `$column` FROM `$table` WHERE `id` = '$id'";
    $sql = $this->conn->prepare($sql);
    $sql->execute();
    $value = $sql->fetch(PDO::FETCH_ASSOC);
    return $value[$column];
  }

}

$database = new Database(dbHOST, dbUSERNAME, dbPASSWORD);
$database->useDB(database); # Specify what database to use here.

?>
