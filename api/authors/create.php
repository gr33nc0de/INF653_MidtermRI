<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Author.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Author object
$author = new Author($db); 

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->author)) { 
    // Set author property value
    $author->author = $data->author;

    // Create author
    $new_author_id = $author->create();

    if($new_author_id) {
        // If the author was successfully created, return its data
        $author_data = array(
            'id' => $new_author_id,
            'author' => $data->author
        );

        echo json_encode($author_data);
    } else {
        echo json_encode(array('message' => 'Author Not Created'));
    }
} else {
    echo json_encode(array('message' => 'Missing Required Parameters'));
}
