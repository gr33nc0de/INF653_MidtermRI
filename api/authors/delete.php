<?php
  // error_reporting(E_ALL);
  // ini_set('display_errors', 1);

  // CORS
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

  // Necessary files
  include_once '../../config/Database.php';
  include_once '../../models/Author.php';

  // Create Database object
  $database = new Database();
  $db = $database->connect();

  // Create Author object
  $author = new Author($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  if (!empty($data->id)) 
  {
      $author->id = $data->id;

      // Delete author
      if ($author->delete()) 
      {
          // Return ID of deleted author
          echo json_encode(array('id' => $author->id));
      } else 
      {
          echo json_encode(array('message' => 'Author not deleted'));
      }
  } else 
  {
      // ID is missing
      echo json_encode(array('message' => 'Missing Required Parameter: id'));
      die();
  }
?>
