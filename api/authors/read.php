<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  
// Include necessary files
include_once '../../config/Database.php';
include_once '../../models/Author.php';

// Instantiate Database object
$database = new Database();
$db = $database->connect();

// Instantiate Author object
$author = new Author($db);

// Read authors
$result = $author->read();

// Get row count
$num = $result->rowCount();

// Check if any authors
if ($num > 0) {
    // Authors array
    $authors_arr = array();
    $authors_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $author_item = array(
            'id' => $id,
            'author' => $author
        );

        // Push to "data"
        array_push($authors_arr['data'], $author_item);
    }

    // Convert to JSON and output
    echo json_encode($authors_arr);
} else {
    // No authors found
    echo json_encode(array('message' => 'No authors found'));
}
