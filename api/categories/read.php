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

// Read categories
$result = $category->read(); // Assuming your Category model has a read method

// Get row count
$num = $result->rowCount();

// Check if any categories
if ($num > 0) {
    // Categories array
    $categories_arr = array();
    $categories_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $category_item = array(
            'id' => $id,
            'name' => $name // Assuming your category model has a 'name' property
        );

        // Push to "data"
        array_push($categories_arr['data'], $category_item);
    }

    // Convert to JSON and output
    echo json_encode($categories_arr);
} else {
    // No categories found
    echo json_encode(array('message' => 'No categories found'));
}
?>
