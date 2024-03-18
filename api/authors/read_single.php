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

// Attempt to find the author and capture the result
$authorFound = $author->read_single();

if ($authorFound) {
    // Author found, output author data
    $author_arr = array(
        'id' => (int) $author->id, // Casting to int for JSON number format
        'author' => $author->author
    );
    echo json_encode($author_arr);
} else {
    // Author not found, output not found message
    echo json_encode(array('message' => 'author_id Not Found'));
}
?>
