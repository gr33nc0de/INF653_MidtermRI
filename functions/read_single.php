<?php

class CRUDFunctions {
    private $conn;
    private $table;

    public function __construct($db, $table) {
        $this->conn = $db;
        $this->table = $table;
    }

    // Read single record
    public function read_single($id) {
        // Create query
        $query = 'SELECT
                    q.id,
                    q.quote,
                    q.author,
                    c.category as category
                FROM
                    ' . $this->table . ' q
                    LEFT JOIN
                        categories c ON q.category_id = c.id
                WHERE
                    q.id = ?
                LIMIT 0,1';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $id);

        // Execute query
        $stmt->execute();

        return $stmt;
    }
}
?>
