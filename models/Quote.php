<?php 
class Quote {
  // DB stuff
  private $conn;
  private $table = 'quotes';

  // Quote Properties
  public $id;
  public $quote;
  public $author_id;
  public $category_id;
  public $author_name;
  public $category_name;

  // Constructor with DB
  public function __construct($db) {
    $this->conn = $db;
  }

  // Get Quotes
  public function read() {
    // Create query
    $query = 'SELECT 
                a.author AS author, 
                c.category AS category, 
                q.id, q.quote, q.author_id, q.category_id
              FROM 
                ' . $this->table . ' q
              LEFT JOIN
                authors a ON q.author_id = a.id
              LEFT JOIN
                categories c ON q.category_id = c.id
              ORDER BY
                q.id ASC';
    
    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Execute query
    $stmt->execute();

    return $stmt;
}

 // Get Single Quote
public function read_single() {
  // Create query
  $query = 'SELECT 
              a.author as author_name, 
              c.category as category_name, 
              q.id, q.quote, q.author_id, q.category_id
            FROM 
              ' . $this->table . ' q
            LEFT JOIN
              authors a ON q.author_id = a.id
            LEFT JOIN
              categories c ON q.category_id = c.id
            WHERE
              q.id = ?
            LIMIT 0,1';

  // Prepare statement
  $stmt = $this->conn->prepare($query);

  // Bind ID
  $stmt->bindParam(1, $this->id);

  // Execute query
  $stmt->execute();

  // Check if a quote was found
  if ($stmt->rowCount() > 0) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // Set properties
      $this->quote = $row['quote'];
      $this->author_id = $row['author_id'];
      $this->category_id = $row['category_id'];
      $this->author_name = $row['author_name'];
      $this->category_name = $row['category_name'];
  } else {
      // No quote found with the specified ID
      $this->quote = null;
      $this->author_id = null;
      $this->category_id = null;
      $this->author_name = null;
      $this->category_name = null;
  }
}

}
