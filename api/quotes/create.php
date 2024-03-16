<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

// Include necessary files
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

// Instantiate Database object
$database = new Database();
$db = $database->connect();

// Instantiate Quote object
$quote = new Quote($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->quote) && !empty($data->author_id) && !empty($data->category_id)) {
    // Set quote property values
    $quote->quote = $data->quote;
    $quote->author_id = $data->author_id;
    $quote->category_id = $data->category_id;

    // Create quote
    if ($quote->create()) {
        echo json_encode(array('message' => 'Quote Created'));
    } else {
        echo json_encode(array('message' => 'Quote Not Created'));
    }
} else {
    echo json_encode(array('message' => 'Missing required parameters'));
}
?>
