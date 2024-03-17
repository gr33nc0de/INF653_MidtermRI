<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

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

// Check if the quote exists before attempting deletion
if (!$quote->exists()) {
    echo json_encode(array('message' => 'No Quotes Found'));
} else {
    // Delete quote
    if ($quote->delete()) {
        echo json_encode(
            array(
                'message' => 'Quote deleted',
                'id' => $quote->id // Assuming $quote->id is still set to the deleted quote's id
            )
        );
    } else {
        echo json_encode(array('message' => 'Quote not deleted'));
    }
}
?>
