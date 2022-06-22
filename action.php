<?php

define('dbHOST', 'localhost');
define('dbUSERNAME', 'root');
define('dbPASSWORD', '');
define('database', 'interview_db');

require './db_functions.php';

// POST Requests
if ($_SERVER['REQUEST_METHOD'] === "POST") {
  if ($_POST['action'] === 'add') {
    $parent = empty($_POST['parent']) ? 0 : $_POST['parent'];
    if (!empty($parent)) {
      $hierarchy = $database->idValue('category', 'hierarchy', $_POST['parent']) + 1;
    } else {
      $hierarchy = 0;
    }

    $columns = ['category', 'parent', 'hierarchy'];
    $values = [$_POST['category'], $parent, $hierarchy];
    $response = $database->insertTbl('category', $columns, $values);

    echo $response;
  }

  if ($_POST['action'] === 'edit') {
    $parent = empty($_POST['parent']) ? 0 : $_POST['parent'];
    if (!empty($parent)) {
      $hierarchy = $database->idValue('category', 'hierarchy', $_POST['parent']) + 1;
    } else {
      $hierarchy = 0;
    }

    $values = ['category' => $_POST['category'], 'parent' => $parent, 'hierarchy' => $hierarchy];
    $response = $database->updateWhere('category', $values, 'id = '.$_POST['id']);

    echo $response;
  }

  if ($_POST['action'] === 'delete') {
    $data = $database->selectAllWhere('category', 'parent = '.$_POST['id']);
    if (count($data) == 0) {
      $response = $database->deleteWhere('category', 'id = '.$_POST['id']);
    } else {
      $response = false;
    }
    echo json_encode($response);
  }
}

// GET Requests
if ($_SERVER['REQUEST_METHOD'] === "GET") {
  if ($_GET['action'] === 'all') {
    $categories = $database->selectAll('category');
    echo json_encode($categories);
  }
}
