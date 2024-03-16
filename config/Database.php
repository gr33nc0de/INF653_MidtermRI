<?php 
  class Database 
  {
    // DB Params
    private $conn;
    private $host;
    private $port;
    private $dbname;
    private $username;
    private $password;

    public function __construct() 
    {
      $this->username = getenv('USERNAME');
      $this->password = getenv('PASSWORD');
      $this->dbname = getenv('DBNAME');
      $this->host = getenv('HOST');
      $this->port = getenv('PORT');
    }

    public function connect()
    {
      if($this->conn)
      {
        //connection already exists, return it
        return $this->conn;
      } else
      {
        $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname};";

        try 
        {
          $this->conn = new PDO($dsn,$this->username,$this->password);
          $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          return $this->conn; 
        } catch(PDOEXCEPTION $e) {
          echo 'Connection Error: ' . $e->getMessage();
        }
      }
    }
  }

echo "postgres://test01db_bwpt_user:6FntKCOD0eUzsIttCWH09Vb1o6enW2J0@dpg-cnpg5hf109ks73eu5j50-a.oregon-postgres.render.com/test01db_bwpt";
  