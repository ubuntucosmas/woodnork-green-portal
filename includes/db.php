<?php
class database {
    private static $instance = null;
    private $pdo;
    
    private function __construct() {
        // Database credentials
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "portal_db";
        
        try {
            // Create a new PDO connection
            $this->pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Log the error to a file
            file_put_contents('error_log.txt', $e->getMessage(), FILE_APPEND);
            // Show a generic error message
            die('Database connection error.');
        }
    }

    // Get the singleton instance of the Database
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Get the PDO connection object
    public function getConnection() {
        return $this->pdo;
    }
}
?>
  