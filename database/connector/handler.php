<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use Dotenv\Dotenv;
$envPath = __DIR__ . '/../../.env';
if (!file_exists($envPath)) {
    die(".env file doesn't exist. Please create a new one.");
} else {
    $dotenv = Dotenv::createImmutable(dirname($envPath)); 
    $dotenv->load();
    $db_host = $_ENV['DB_HOST'] ?? 'localhost';  
    $db_user = $_ENV['DB_USERNAME'] ?? 'root';
    $db_pass = $_ENV['DB_PASSWORD'] ?? '';
    $db_name = $_ENV['DB_NAME'] ?? 'todo';

    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

}
