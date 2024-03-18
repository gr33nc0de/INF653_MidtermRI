<?php
// CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Include necessary files
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

// Create Database object and connect
$database = new Database();
$db = $database->connect();

// Create Quote object
$quote = new Quote($db);

// Get quote ID from URL
$quote_id = isset($_GET['id']) ? $_GET['id'] : null;

// Check if the ID is provided
if ($quote_id === null) {
    echo json_encode(['message' => 'No Quote ID Provided']);
    exit(); // Prevent further execution if no ID is provided
}

// Set ID for quote to read
$quote->id = $quote_id;
//echo "Here is the quote id: $quote_id"; 

// Read single quote
$quote->read_single();

// Check if quote exists
if ($quote->quote !== null) {
    // Quote exists
    $quote_arr = array(
        'id' => $quote->id,
        'quote' => $quote->quote,
        'author_id' => $quote->author_id,
        'category_id' => $quote->category_id,
        'author' => $quote->author_name,
        'category' => $quote->category_name
    );

    // Make JSON and output
    echo json_encode($quote_arr);
} else {
    // No quote found with that ID
    echo json_encode(['message' => 'No Quote Found']);
}
?>
