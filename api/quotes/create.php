<?php

    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);

    // CORS
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    // Necessary files
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Create Database object & connect to the db
    $database = new Database();
    $db = $database->connect();

    // Create Quote object
    $quote = new Quote($db);

    // Get posted data
    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->quote) && isset($data->author_id) && isset($data->category_id)) 
    {
        // Check if author and category exist
        $authorExists = $quote->authorExists($data->author_id);
        $categoryExists = $quote->categoryExists($data->category_id);

        if (!$authorExists) 
        {
            echo json_encode(array('message' => 'author_id Not Found'));
            return; // Stop if author_id not found
        }

        if (!$categoryExists) 
        {
            echo json_encode(array('message' => 'category_id Not Found'));
            return; // Stop if category_id not found
        }

        // Set quote property values
        $quote->quote = $data->quote;
        $quote->author_id = $data->author_id;
        $quote->category_id = $data->category_id;

        // Try to create quote
        if ($quote->create()) 
        {
            // If quote was successfully created
            $newQuoteData = array(
                'id' => $db->lastInsertId(),
                'quote' => $data->quote,
                'author_id' => $data->author_id,
                'category_id' => $data->category_id
            );
            echo json_encode($newQuoteData);
        } else 
        {
            echo json_encode(array('message' => 'Quote Not Created'));
        }
    } else 
    {
        echo json_encode(array('message' => 'Missing Required Parameters'));
    }
?>