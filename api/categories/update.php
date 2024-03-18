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

// Check if data is not empty and id is set
if (!empty($data->id) && !empty($data->category)) 
{
    // Set category property values
    $category->id = $data->id;
    $category->category = $data->category;

    // Update category
    if ($category->update()) {
        // Prepare the response array
        $response = array(
            "id" => $category->id,
            "category" => $category->category
        );

        // Return the response in JSON format
        echo json_encode($response);
    } else 
    {
        echo json_encode(array('message' => 'Category Not Updated'));
    }
} else 
{
    echo json_encode(array('message' => 'Missing Required Parameters'));
}
?>

