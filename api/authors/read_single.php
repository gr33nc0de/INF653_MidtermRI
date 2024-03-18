<?php

// CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Author.php';

// Create Database object
$database = new Database();
$db = $database->connect();

// Create Author object
$author = new Author($db);

// Get author id from URL
$author->id = isset($_GET['id']) ? $_GET['id'] : die("Author ID not provided.");

// Read single author
$author->read_single(); 

// Attempt to read single author
if ($author->read_single()) {
  // Author found
  $author_arr = [
      'id' => (int) $author->id, // Casting to int for JSON number output
      'author' => $author->author,
  ];
  echo json_encode($author_arr);
} else {
  // Author not found
  echo json_encode(['message' => 'author_id Not Found']);
}
?>

