<?php
class Database {
    private $servername = "localhost"; 
    private $port = "3306"; 
    private $username = "root"; 
    private $password = ""; 
    private $dbname = "final1"; 
    private $conn;

    // Singleton instance
    private static $instance;

    // Private constructor to prevent direct instantiation
    private function __construct() {
        $this->connect();
    }

    // Ensure only one instance of the connection exists
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Database connection method
    private function connect() {
        // Check if connection is already established
        if ($this->conn === null) {
            // Establish a connection
            $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname, $this->port);
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
        }
    }

    // Get the connection instance
    public function getConnection() {
        return $this->conn;
    }

    // Optionally close the connection manually when done
    public function closeConnection() {
        if ($this->conn !== null) {
            $this->conn->close();
            $this->conn = null;  // Reset the connection
        }
    }
}
