<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Include necessary files
include_once '../../config/Database.php';
include_once '../../models/Category.php'; // Change to Category model

// Instantiate Database object
$database = new Database();
$db = $database->connect();

// Instantiate Category object
$category = new Category($db); // Change to Category object

// Get category id from URL
$category->id = isset($_GET['id']) ? $_GET['id'] : die();

// Read single category
$category->read_single(); // Assuming your Category model has a read_single method

// Create array
$category_arr = array(
    'id' => $category->id,
    'name' => $category->name // Assuming your category model has a 'name' property
);

// Make JSON
echo json_encode($category_arr);
?>
