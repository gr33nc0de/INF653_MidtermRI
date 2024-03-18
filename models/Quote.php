<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Quote 
{
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
  public function __construct($db) 
  {
    $this->conn = $db;
  }

  // 1. read() to get all quotes
  public function read() 
  {
    // SQL Query
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

  // 2. read_single to get 1 quote
  public function read_single() 
  {
    // SQL Query
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
              LIMIT 1';

    // Prepare statement
    //var_dump($this->conn); // Check if PDO object & not null
    $stmt = $this->conn->prepare($query);

    // Bind ID
    $stmt->bindParam(1, $this->id);

    // Execute query
    $stmt->execute();

    // Check if a quote was found
    if ($stmt->rowCount() > 0) 
    {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->quote = $row['quote'];
        $this->author_id = $row['author_id'];
        $this->category_id = $row['category_id'];
        $this->author_name = $row['author_name'];
        $this->category_name = $row['category_name'];
    } else 
    {
        // No quote found with the specified ID
        $this->quote = null;
        $this->author_id = null;
        $this->category_id = null;
        $this->author_name = null;
        $this->category_name = null;
    }
  }

  // 3. create() to Create Quote (POST)
  public function create() 
  {
    // Create query
    $query = 'INSERT INTO ' . $this->table . ' (quote, author_id, category_id) VALUES (:quote, :author_id, :category_id)';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean fields
    $this->quote = htmlspecialchars(strip_tags($this->quote));
    $this->author_id = htmlspecialchars(strip_tags($this->author_id));
    $this->category_id = htmlspecialchars(strip_tags($this->category_id));

    // Bind fields
    $stmt->bindParam(':quote', $this->quote);
    $stmt->bindParam(':author_id', $this->author_id);
    $stmt->bindParam(':category_id', $this->category_id);

    try 
    {
        // Execute query
        $stmt->execute();
        return $this->conn->lastInsertId(); // Return last inserted ID
    } catch(PDOException $e) 
    {
        // Check if error code indicates a foreign key violation
        if ($e->getCode() == '23503') 
        {
            // Check if author_id does not exist
            $authorExists = $this->authorExists($this->author_id);
            if (!$authorExists) 
            {
                return 'author_id_not_found';
            }

            // Check if category_id does not exist
            $categoryExists = $this->categoryExists($this->category_id);
            if (!$categoryExists) 
            {
                return 'category_id_not_found';
            }
        }

        // For other errors
        error_log('PDOException: ' . $e->getMessage());
        return false;
    }
  }

// 4. update() to Update Quote (PUT)
public function update() 
{
    // Check if quote exists
    if (!$this->quoteExists()) 
    {
        return 'no_quote_found';
    }

    // Verify if the author exists
    if (!$this->authorExists($this->author_id)) 
    {
        return 'author_id_not_found';
    }

    // Verify if the category exists
    if (!$this->categoryExists($this->category_id)) 
    {
        return 'category_id_not_found';
    }

    // Update query
    $query = "UPDATE " . $this->table . "
              SET
                quote = :quote,
                author_id = :author_id,
                category_id = :category_id
              WHERE
                id = :id";

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data and bind parameters
    $this->quote = htmlspecialchars(strip_tags($this->quote));
    $stmt->bindParam(':quote', $this->quote);
    $stmt->bindParam(':author_id', $this->author_id);
    $stmt->bindParam(':category_id', $this->category_id);
    $stmt->bindParam(':id', $this->id);

    // Execute the query
    if ($stmt->execute()) 
    {
        return 'updated';
    }

    return 'update_failed';
}


  // 5. delete() to Delete Quote

  // 6. Check if the quote exists
  private function quoteExists() 
  {
    $query = "SELECT id FROM " . $this->table . " WHERE id = ? LIMIT 1";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id);
    $stmt->execute();

    return $stmt->rowCount() > 0;
  }

  // 7. Check if author exists
  public function authorExists($authorId) 
  {
    $query = 'SELECT COUNT(*) FROM authors WHERE id = :author_id';

    // Prepare statement
    $stmt = $this->conn->prepare($query);
    
    // Bind ID
    $stmt->bindParam(':author_id', $authorId);

    // Execute query
    $stmt->execute();

    // Check if any rows returned
    if ($stmt->fetchColumn()) 
    {
        return true;
    } else {
        return false;
    }
}

  // 7. Check if category exists
  public function categoryExists($categoryId) 
  {
      $query = 'SELECT COUNT(*) FROM categories WHERE id = :category_id';

      // Prepare statement
      $stmt = $this->conn->prepare($query);
      
      // Bind ID
      $stmt->bindParam(':category_id', $categoryId);

      // Execute query
      $stmt->execute();

      // Check if any rows returned
      if ($stmt->fetchColumn()) 
      {
          return true;
      } else {
          return false;
      }
  }
}
?>