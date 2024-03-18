<?php
    // CORS
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    // Necessary files
    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    // Create Database object
    $database = new Database();
    $db = $database->connect();

    // Create Author object
    $author = new Author($db);

    // Get author id from URL
    $author->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Try to find author
    $authorFound = $author->read_single();

    if ($authorFound) 
    {
        // Author found, output author data
        $author_arr = array(
            'id' => (int) $author->id,
            'author' => $author->author
        );
        echo json_encode($author_arr);
    } else 
    {
        // Author not found
        echo json_encode(array('message' => 'author_id Not Found'));
    }
?>
