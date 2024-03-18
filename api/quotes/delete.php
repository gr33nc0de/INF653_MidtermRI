<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

// Include necessary files
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

// Create Database object
$database = new Database();
$db = $database->connect();

// Create Quote object
$quote = new Quote($db);

echo "passes here";
// Get quote id from URL
$quote->id = isset($_GET['id']) ? $_GET['id'] : die();
echo "passes here 2";

// Check if quote exists before trying to delete 
if (!$quote->quoteExists()) 
{
    echo json_encode(array('message' => 'No Quotes Found'));
} else 
{
    // Delete quote
    if ($quote->delete()) {
        echo json_encode(
            array('id' => $quote->id)
        );
    } else {
        echo json_encode(array('message' => 'Quote not deleted'));
    }
}

?>
