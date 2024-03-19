<?php
    // CORS
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    // Necessary files
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Create Database object
    $database = new Database();
    $db = $database->connect();

    // Create Quote object
    $quote = new Quote($db);

    // Get quote id from request body
    $data = json_decode(file_get_contents("php://input"));

    // Check if id is provided in the request body
    if (!empty($data->id)) 
    {
        // Set id property of quote object
        $quote->id = $data->id;

        // Check if quote exists 
        if ($quote->quoteExists()) 
        {
            // Delete quote
            if ($quote->delete()) 
            {
                // Return id of deleted quote in JSON
                echo json_encode(array('id' => $quote->id));
            } else 
            {
                echo json_encode(array('message' => 'Quote not deleted'));
            }
        } else 
        {
            echo json_encode(array('message' => 'No Quotes Found'));
        }
    } else {
        // If id is not in request body
        echo json_encode(array('message' => 'Missing id in request body'));
    }
?>
