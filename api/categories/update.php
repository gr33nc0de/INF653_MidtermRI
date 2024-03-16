<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

// Include necessary files
include_once '../../config/Database.php';
include_once '../../models/Category.php'; // Change to Category model

// Instantiate Database object
$database = new Database();
$db = $database->connect();

// Instantiate Category object
$category = new Category($db); // Change to Category object

// Get posted data
$data = json_decode(file_get_contents("php://input"));

// Check if data is not empty
if (!empty($data->name)) { // Assuming your category update requires a 'name' field
    // Set category property values
    $category->id = $data->id; // Assuming your category update requires an 'id' field
    $category->name = $data->name;

    // Update category
    if ($category->update()) { // Assuming your Category model has an 'update' method
        echo json_encode(array('message' => 'Category updated'));
    } else {
        echo json_encode(array('message' => 'Category not updated'));
    }
} else {
    echo json_encode(array('message' => 'Missing required parameters'));
}
?>
