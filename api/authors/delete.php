<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  // Include necessary files
  include_once '../../config/Database.php';
  include_once '../../models/Author.php';

// Instantiate Database object
$database = new Database();
$db = $database->connect();

// Instantiate Author object
$author = new Author($db);

// Get author id from URL
$author->id = isset($_GET['id']) ? $_GET['id'] : die();

// Delete author
if ($author->delete()) {
    echo json_encode(array('message' => 'Author deleted'));
} else {
    echo json_encode(array('message' => 'Author not deleted'));
}
?>