<?php 
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

class Author {
  // DB stuff
  private $conn;
  private $table = 'authors';

  // Author Properties
  public $id;
  public $author;

  // Constructor with DB
  public function __construct($db) {
    $this->conn = $db;
  }

  // Get Authors
  public function read() {
    // Create query
    $query = 'SELECT
                id, author
              FROM 
                ' . $this->table . '
              ORDER BY
                author ASC'; // 
    
    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Execute query
    $stmt->execute();

    return $stmt;
  }

  // Get Single Author
  public function read_single() {
    // Query to check if author exists
    $query = 'SELECT id, author FROM ' . $this->table . ' WHERE id = ? LIMIT 1';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind ID
    $stmt->bindParam(1, $this->id);

    // Execute query
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if any row is returned
    if ($row) {
        // Author exists, set properties
        $this->author = $row['author'];
        return true; // Indicate author was found
    } else {
        // No author found
        return false; // Indicate no author was found
    }
}


  // Create Author
  public function create() {
    // Create query
    $query = 'INSERT INTO ' . $this->table . ' SET author = :author';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->author = htmlspecialchars(strip_tags($this->author));

    // Bind data
    $stmt->bindParam(':author', $this->author);

    // Execute query
    if($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  // Update Author
  public function update() {
    // Create query
    $query = 'UPDATE ' . $this->table . ' SET author = :author WHERE id = :id';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->author = htmlspecialchars(strip_tags($this->author));
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind data
    $stmt->bindParam(':author', $this->author);
    $stmt->bindParam(':id', $this->id);

    // Execute query
    if($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  // Delete Author
  public function delete() {
    // Create query
    $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind data
    $stmt->bindParam(':id', $this->id);

    // Execute query
    if($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }
}