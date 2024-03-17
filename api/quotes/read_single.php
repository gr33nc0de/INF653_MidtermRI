<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Include necessary files
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

// Instantiate Database object and connect
$database = new Database();
$db = $database->connect();

// Instantiate Quote object
$quote = new Quote($db);

// Get quote id from URL
$quote_id = isset($_GET['id']) ? $_GET['id'] : die();

// Set the ID for the quote to read
$quote->id = $quote_id;

// Read single quote
$result = $quote->read_single();

// Check if any quote is found
if($quote->quote !== null) {
    // Create array
    $quote_arr = array(
        'id' => $quote->id,
        'quote' => $quote->quote,
        'author' => $quote->author, 
        'category' => $quote->category 
    );

    // Make JSON
    echo json_encode($quote_arr);
} else {
    // No quote found
    echo json_encode(array('message' => 'No Quote Found with that ID'));
}
?>
