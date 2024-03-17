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

// Read quotes
$result = $quote->read();

// Get row count
$num = $result->rowCount();

// Check if any quotes
if ($num > 0) {
    // Quotes array
    $quotes_arr = array();
    $quotes_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        // Extracting individual fields from $row
        $id = $row['id'];
        $quote_text = $row['quote'];
        $author = $row['author'];
        $category = $row['category'];

        $quote_item = array(
            'id' => $id,
            'quote' => $quote_text,
            'author' => $author, 
            'category' => $category 
        );

        // Push to "data"
        array_push($quotes_arr['data'], $quote_item);
    }

    // Convert to JSON and output
    echo json_encode($quotes_arr);
} else {
    // No quotes found
    echo json_encode(array('message' => 'No quotes found'));
}
?>
