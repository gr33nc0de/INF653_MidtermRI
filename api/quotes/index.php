<?php
// CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

// Include necessary files
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

// Create Database object
$database = new Database();
$db = $database->connect();

// Create Quote object
$quote = new Quote($db);

// Determine HTTP request method & route
switch ($method) {
    case 'GET':
        // Check if request has an 'id' parameter
        $quote_id = isset($_GET['id']) ? $_GET['id'] : null;
        if ($quote_id !== null) {
            // GET request for a single quote
            include_once 'read_single.php'; // if given id param 
        } else {
            // GET request for all quotes
            include_once 'read.php';
        }
        break;
    case 'POST':
        // POST request
        include_once 'create.php';
        break;
    case 'PUT':
        // PUT request
        include_once 'update.php';
        break;
    case 'DELETE':
        // DELETE request
        include_once 'delete.php';
        break;
    default:
        // Invalid input
        http_response_code(405); // Method Not Allowed
        echo json_encode(array("message" => "Method not allowed"));
        break;
}
?>
