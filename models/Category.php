<?php 
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

class Category 
{
  // DB stuff
  private $conn;
  private $table = 'categories';

  // Category Properties
  public $id;
  public $category;

  // Constructor with DB
  public function __construct($db) 
  {
    $this->conn = $db;
  }

  // 1. Read() to Get Categories
  public function read() 
  {
    // Create query
    $query = 'SELECT
                id, category
              FROM 
                ' . $this->table . '
              ORDER BY
                category ASC'; 
    
    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Execute query
    $stmt->execute();

    return $stmt;
  }

  // 2. Read_single() to Get Single Category
  public function read_single() 
  {
    // Create query
    $query = 'SELECT
                id, category
              FROM 
                ' . $this->table . '
              WHERE
                id = ?
              LIMIT 1';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind ID
    $stmt->bindParam(1, $this->id);

    // Execute query
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if any row is returned
    if ($row) 
    {
        // Category exists, set properties
        $this->category = $row['category'];
        return true; // Indicate Category was found
    } else 
    {
        // No Category found
        return false; // Indicate no Category was found
    }
  }

  // 3. create() to create Category (POST)
  public function create() 
  {
    // Create query
    $query = 'INSERT INTO ' . $this->table . ' (category) VALUES (:category)';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->category = htmlspecialchars(strip_tags($this->category));

    // Bind data
    $stmt->bindParam(':category', $this->category);

    // Execute query
    if($stmt->execute()) 
    {
      return $this->conn->lastInsertId();
    }

    // Return false if execution fails
    return false;
  }


  // 4. update() to Update Category (PUT)
  public function update() 
  {
    // Create query
    $query = 'UPDATE ' . $this->table . ' SET category = :category WHERE id = :id';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->category = htmlspecialchars(strip_tags($this->category));
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind data
    $stmt->bindParam(':category', $this->category);
    $stmt->bindParam(':id', $this->id);

    // Execute query
    if($stmt->execute()) 
    {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  // 5. delete() to Delete Category
  public function delete() 
  {
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
?>