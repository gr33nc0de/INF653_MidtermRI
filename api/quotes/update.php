<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Include necessary files
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

// Create Database object and connect
$database = new Database();
$db = $database->connect();

// Create Quote object
$quote = new Quote($db);

// Get posted data
$data = json_decode(file_get_contents("php://input"));

// Check all required parameters are present
if (!empty($data->id) && !empty($data->quote) && isset($data->author_id) && isset($data->category_id)) {
    $quote->id = $data->id;
    $quote->quote = $data->quote;
    $quote->author_id = $data->author_id;
    $quote->category_id = $data->category_id;

    // Try to update quote
    $result = $quote->update();

    // Check for different types of failure or success
    switch ($result) {
        case 'updated':
            echo json_encode(array(
                'id' => $quote->id,
                'quote' => $quote->quote,
                'author_id' => $quote->author_id,
                'category_id' => $quote->category_id
            ));
            break;
        case 'no_quote_found':
            echo json_encode(array('message' => 'No Quotes Found'));
            break;
        case 'author_id_not_found':
            echo json_encode(array('message' => 'author_id Not Found'));
            break;
        case 'category_id_not_found':
            echo json_encode(array('message' => 'category_id Not Found'));
            break;
        default:
            echo json_encode(array('message' => 'Quote not updated'));
            break;
    }
} else {
    echo json_encode(array('message' => 'Missing Required Parameters'));
}
?>
