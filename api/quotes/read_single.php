<?php
    // CORS
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    // Necessary files
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Create Database object and connect
    $database = new Database();
    $db = $database->connect();

    // Create Quote object
    $quote = new Quote($db);

    // Get quote id from URL
    $quote->id = isset($_GET['id']) ? $_GET['id'] : die("Quote ID not provided.");

    // Read 1 quote
    $quote->read_single();

    // Check if quote was found
    if (!empty($quote->quote)) 
    {
        // Create array
        $quote_arr = array(
            'id' => (int)$quote->id,
            'quote' => $quote->quote,
            'author' => $quote->author_name,
            'category' => $quote->category_name
        );

        // Make JSON
        echo json_encode($quote_arr);
    } else 
    {
        // No quote found
        echo json_encode(array('message' => 'No Quotes Found'));
    }
?>