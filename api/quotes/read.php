<?php
    // CORS
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    // Necessary files
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Create Database object
    $database = new Database();
    $db = $database->connect();

    // Create Quote object
    $quote = new Quote($db);

    // Read quotes
    $result = $quote->read();

    // Get row count
    $num = $result->rowCount();

    // Check if any quotes
    if ($num > 0) 
    {
        // Quotes array
        $quotes_arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
        {
            extract($row);
        
            $quote_item = array(
                'id' => $id,
                'quote' => $quote,
                'author' => $author,
                'category' => $category 
            );
        
            // Push to array
            $quotes_arr[] = $quote_item;
        }

        // Convert to JSON and output
        //echo 'Running the read file';
        echo json_encode($quotes_arr);
    } else 
    {
        echo json_encode(array('message' => 'No Quotes Found'));
    }
?>
