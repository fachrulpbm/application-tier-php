<?php
class Model {
    protected $conn;
    protected $table;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    protected function executeQuery($query, $params = []) {
        try {
            $stmt = $this->conn->prepare($query);
            
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            
            $stmt->execute();
            return $stmt;
            
        } catch(PDOException $e) {
            throw new Exception("Query Error: " . $e->getMessage());
        }
    }
}