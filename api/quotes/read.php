<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Include database and functions files
include_once '../../config/Database.php';
include_once '../../functions/quote_functions.php';

// Instantiate Database object
$database = new Database();
$db = $database->connect();

// Get quotes
$quotes_arr = getQuotes($db);

// Check if more than 0 records found
if (isset($quotes_arr['data']) && count($quotes_arr['data']) > 0) {
    // Convert to JSON and output
    echo json_encode($quotes_arr);
} else {
    // No quotes found
    echo json_encode($quotes_arr); // This will output the message 'No quotes found' if that's the case
}
?>
