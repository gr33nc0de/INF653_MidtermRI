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

    // Read authors
    $result = $author->read();

    // Get row count
    $num = $result->rowCount();

    // Check if any authors
    if ($num > 0) 
    {
        // Authors array
        $authors_arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
        {
            extract($row);

            $author_item = array(
                'id' => $id,
                'author' => $author
            );

            // Push to authors array directly
            array_push($authors_arr, $author_item);
        }

        // Convert to JSON and output directly
        echo json_encode($authors_arr);
    } else 
    {
        // No authors found
        echo json_encode(array('message' => 'No authors found'));
    }
?>