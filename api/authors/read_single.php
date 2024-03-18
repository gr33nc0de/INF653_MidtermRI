<?php

// CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

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

// Read single author
$author->read_single();

// Check if the category name was set
if (!empty($author->author)) {
  // Create array
  $author_arr = array(
      'id' => $author->id,
      'author' => $author->author
  );

  // Make JSON
  echo json_encode($author_arr);
} else {
  // No category found
  echo json_encode(array('message' => 'author_id Not Found'));
}

