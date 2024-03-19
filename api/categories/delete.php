<?php
  // CORS
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  // Necessary files
  include_once '../../config/Database.php';
  include_once '../../models/Category.php'; 

  // Create Database object
  $database = new Database();
  $db = $database->connect();

  // Create Category object
  $category = new Category($db); // Change from category to Category

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  if (!empty($data->id)) 
  {
    $category->id = $data->id;

    // Delete category
    if ($category->delete()) 
    {
        // Return ID of deleted category
        echo json_encode(array('id' => $category->id));
    } else 
    {
        echo json_encode(array('message' => 'Category not deleted'));
    }
} else 
{
    // ID is missing
    echo json_encode(array('message' => 'Missing Required Parameter: id'));
    die();
}
?>

