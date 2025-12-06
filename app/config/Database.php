<?php
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $charset;
    public $conn;

    public function __construct() {
        $this->host = Config::$DB_HOST;
        $this->db_name = Config::$DB_NAME;
        $this->username = Config::$DB_USER;
        $this->password = Config::$DB_PASS;
        $this->charset = Config::$DB_CHARSET;
    }

    public function getConnection() {
        $this->conn = null;
        
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset={$this->charset}";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];
            
            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
            
        } catch(PDOException $e) {
            echo json_encode([
                "success" => false, 
                "message" => "Database connection failed: " . $e->getMessage()
            ]);
            exit();
        }
        
        return $this->conn;
    }
}