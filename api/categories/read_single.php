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
$result = $quote->read_single();

// Get row count
$num = $result->rowCount();

// Check if any quote found
if ($num > 0) {
    // Fetch quote record
    $row = $result->fetch(PDO::FETCH_ASSOC);

    // Extract row values
    extract($row);

    // Create array
    $quote_arr = array(
        'id' => $id,
        'quote' => $quote,
        'author' => $author,
        'category' => $category
    );

    // Make JSON
    echo json_encode($quote_arr);
} else {
    // No quote found
    echo json_encode(array('message' => 'No quote found with that ID'));
}
?>
