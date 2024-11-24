<?php
require_once 'SessionConfig.php';

class Database {
    private const HOST = 'localhost';
    private const DB_USERNAME = 'root';
    private const DB_PASSWORD = '';
    private const DATABASE = 'counseling';

    protected $connection;

    public function __construct() {
        $this->connection = mysqli_connect(self::HOST, self::DB_USERNAME, self::DB_PASSWORD, self::DATABASE);

        if (!$this->connection) {
            error_log("Database connection error: " . mysqli_connect_error());
            throw new Exception("Unable to connect to the database.");
        }
    }

    protected function executeQuery($query, $paramTypes, $redirectUrl, ...$params) {
        $stmt = $this->connection->prepare($query);
    
        if (!$stmt) {
            $_SESSION['query_error'] = "Error preparing statement: " . $this->connection->error;
            header("Location: $redirectUrl");
            die();
        }
    
        // Bind parameters dynamically
        if (!empty($paramTypes) && !empty($params)) {
            $stmt->bind_param($paramTypes, ...$params);
        }
    
        $result = $stmt->execute();
    
        if (!$result) {
            $_SESSION['query_error'] = "Error executing query: " . $stmt->error;
            header("Location: $redirectUrl");
            die();
        }
    
        return $stmt;
    }
}