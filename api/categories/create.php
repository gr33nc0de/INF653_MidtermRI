<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Category.php'; 

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Category object
  $category = new Category($db); 

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  if (!empty($data->name)) { 
    // Set category property values
    $category->name = $data->name;

    // Create category
    if($category->create()) {
      echo json_encode(
        array('message' => 'Category Created')
      );
    } else {
      echo json_encode(
        array('message' => 'Category Not Created')
      );
    }
  } else {
    echo json_encode(
      array('message' => 'Missing Required Parameters')
    );
  }
?>
