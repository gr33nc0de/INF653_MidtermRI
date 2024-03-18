<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    // Include necessary files
    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    // Instantiate Database object
    $database = new Database();
    $db = $database->connect();

    // Instantiate Author object
    $author = new Author($db);

    // Get posted data
    $data = json_decode(file_get_contents("php://input"));

    // Check if data is not empty and id is set
    if (!empty($data->id) && !empty($data->author)) 
    {
        // Set author property values
        $author->id = $data->id;
        $author->author = $data->author;

        // Update author
        if ($author->update()) 
        {
            // Prepare the response array
            $response = array(
                "id" => $author->id,
                "author" => $author->author
            );

            // Return the response in JSON format
            echo json_encode($response);
        } else 
        {
            echo json_encode(array('message' => 'Author Not Updated'));
        }
    } else 
    {
        echo json_encode(array('message' => 'Missing Required Parameters'));
    }
?>
