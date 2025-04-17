<?php
namespace App;
use Dotenv\Dotenv;

require_once '../vendor/autoload.php';

class DbConnection {
    // Database credentials
    private $servername;
    private $username;
    private $password;
    private $dbname;

    // Database connection object
    private $conn;

    // Constructor to establish the connection
    public function __construct() {

        // Load .env first
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();

        // Now assign the values
        $this->servername = $_ENV['SERVERNAME'];
        $this->username = $_ENV['USERNAME'];
        $this->password = $_ENV['PASSWORD'];
        $this->dbname = $_ENV['DBNAME'];

        // Connect to DB
        $this->conn = $this->connect();
    }

    // Method to establish the database connection
    private function connect() {
        $conn = new \mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($conn->connect_error) {
            error_log("Database connection failed: " . $conn->connect_error);
            die("Internal server error. Please try again later.");
        }

        return $conn;
    }

    // Method to get the database connection
    public function getConnection() {
        // echo "Connection established";
        return $this->conn;
    }
}

?>
