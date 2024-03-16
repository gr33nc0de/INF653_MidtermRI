<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Include necessary files
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

// Instantiate Database object
$database = new Database();
$db = $database->connect();

// Instantiate Quote object
$quote = new Quote($db);

// Get quote id from URL
$quote->id = isset($_GET['id']) ? $_GET['id'] : die();

// Read single quote
$quote->read_single();

// Create array
$quote_arr = array(
    'id' => $quote->id,
    'quote' => $quote->quote,
    'author' => $quote->author,
    'category' => $quote->category
);

// Make JSON
print_r(json_encode($quote_arr));
?>
