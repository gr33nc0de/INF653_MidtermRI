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
$category->id = isset($_GET['id']) ? $_GET['id'] : die();

// Attempt to find the author and capture the result
$categoryFound = $category->read_single();

if ($categoryFound) {
    // Author found, output author data
    $category_arr = array(
        'id' => (int) $category->id, // Casting to int for JSON number format
        'category' => $category->category
    );
    echo json_encode($category_arr);
} else {
    // Author not found, output not found message
    echo json_encode(array('message' => 'category_id Not Found'));
}

?>

