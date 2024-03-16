<?php
// CORS headers
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
include_once '../../models/Category.php'; // Update to Category model

// Instantiate Database object
$database = new Database();
$db = $database->connect();

// Instantiate Category object
$category = new Category($db); // Update to Category object

// Determine the HTTP request method and route accordingly
switch ($method) {
    case 'GET':
        // Handle GET request
        include_once 'read.php'; // Include read.php for fetching categories
        break;
    case 'POST':
        // Handle POST request
        include_once 'create.php'; // Include create.php for adding new category
        break;
    case 'PUT':
        // Handle PUT request
        include_once 'update.php'; // Include update.php for updating category
        break;
    case 'DELETE':
        // Handle DELETE request
        include_once 'delete.php'; // Include delete.php for deleting category
        break;
    default:
        // Invalid method
        http_response_code(405); // Method Not Allowed
        echo json_encode(array("message" => "Method not allowed"));
        break;
}
?>
