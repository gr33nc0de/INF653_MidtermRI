<?php
  // CORS
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  // Necessary Files
  include_once '../../config/Database.php';
  include_once '../../models/Category.php'; 

  // Create DB & connect
  $database = new Database();
  $db = $database->connect();

  // Create Category object
  $category = new Category($db); 

  // Get posted data
  $data = json_decode(file_get_contents("php://input"));

  if (!empty($data->category)) 
  { 
      // Set category property value
      $category->category = $data->category;

      // Create category
      $new_category_id = $category->create();

      if($new_category_id) 
      {
          // If the category was successfully created, return its data
          $category_data = array(
              'id' => $new_category_id,
              'category' => $data->category
          );

          echo json_encode($category_data);
      } else 
      {
          echo json_encode(array('message' => 'Category Not Created'));
      }
  } else 
  {
      echo json_encode(array('message' => 'Missing Required Parameters'));
  }
?>
