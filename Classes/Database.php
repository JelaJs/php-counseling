<?php
require_once 'SessionConfig.php';

class Database extends SessionConfig {
    private const HOST = 'localhost';
    private const DB_USERNAME = 'root';
    private const DB_PASSWORD = '';
    private const DATABASE = 'counseling';

    public $connection;

    public function __construct() {
        $this->connection = mysqli_connect(self::HOST, self::DB_USERNAME, self::DB_PASSWORD, self::DATABASE);

        if (!$this->connection) {
            error_log("Database connection error: " . mysqli_connect_error());
            throw new Exception("Unable to connect to the database.");
        }

        parent::__construct();
    }
}