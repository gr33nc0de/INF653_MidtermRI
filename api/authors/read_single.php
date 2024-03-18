<?php

// CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();

$author = new Author($db);
$author->id = isset($_GET['id']) ? $_GET['id'] : die("Author ID not provided.");

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
    http_response_code(404); // Optional: Set HTTP status code to 404
    echo json_encode(['message' => 'author_id Not Found']);
}
?>

