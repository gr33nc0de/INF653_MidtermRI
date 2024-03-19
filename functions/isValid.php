<?php
    // Necessary files
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';
    include_once '../../models/Category.php'; 
    include_once '../../models/Author.php';

    function isValid($id, $model) 
    {
        // Set the ID on the model
        $model->id = $id;
        
        // Call the read_single method from the model
        $result = $model->read_single();
        
        // Return the result
        return $result !== null; // Assuming the read_single method returns null if no record is found
    }
?>
