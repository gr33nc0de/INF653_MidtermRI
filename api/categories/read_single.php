<?php

    // CORS
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    // Mecessary files
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Create Database object
    $database = new Database();
    $db = $database->connect();

    // Create Category object
    $category = new Category($db);

    // Get category id from URL
    $category->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Find author and store result
    $categoryFound = $category->read_single();

    if ($categoryFound) 
    {
        // Author found
        $category_arr = array(
            'id' => (int) $category->id,
            'category' => $category->category
        );
        echo json_encode($category_arr);
    } else 
    {
        // Author not found
        echo json_encode(array('message' => 'category_id Not Found'));
    }

?>

