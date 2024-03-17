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

echo 'Here is the quote id: $quote_id';

// Get quote ID from URL
$quote_id = isset($_GET['id']) ? $_GET['id'] : die();

// Set the ID for the quote to read
$quote->id = $quote_id;
echo 'Here is the quote id: $quote_id';

// Attempt to read single quote
$quote->read_single();

// Check if quote exists
if($quote->quote !== null) {
    // Quote exists
    $quote_arr = array(
        'id' => $quote->id,
        'quote' => $quote->quote,
        'author_id' => $quote->author_id,
        'category_id' => $quote->category_id, 
        'author' => $quote->author_name,
        'category' => $quote->category_name 
    );

    // Make JSON
    echo json_encode($quote_arr);
} else {
    // No quote found with that ID
    echo json_encode(['message' => 'No Quote Found']);
}
?>
