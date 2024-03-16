<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  // Include necessary files
  include_once '../../config/Database.php';
  include_once '../../models/Category.php'; // Change from Author to Category

  // Instantiate Database object
  $database = new Database();
  $db = $database->connect();

  // Instantiate Category object
  $category = new Category($db); // Change from Author to Category

  // Get category id from URL
  $category->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Delete category
  if ($category->delete()) {
      echo json_encode(array('message' => 'Category deleted'));
  } else {
      echo json_encode(array('message' => 'Category not deleted'));
  }
?>
