<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Include necessary files
include_once '../../config/Database.php';
include_once '../../models/Category.php';

// Create Database object
$database = new Database();
$db = $database->connect();

// Create Category object
$category = new Category($db);

// Get category id from URL
$category->id = isset($_GET['id']) ? $_GET['id'] : die("Category ID not provided.");

// Read single category
$category->read_single(); 

// Check if the category name was set
if (!empty($category->category)) {
    // Create array
    $category_arr = array(
        'id' => $category->id,
        'category' => $category->category
    );

    // Make JSON
    echo json_encode($category_arr);
} else {
    // No category found
    echo json_encode(array('message' => 'category_id Not Found'));
}

?>