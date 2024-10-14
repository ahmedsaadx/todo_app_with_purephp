<?php
require 'vendor/autoload.php';

use Dotenv\Dotenv;

// Define the path to the .env file (assuming it's in the root of your project)
$envPath = __DIR__ . '/../../.env';

// Check if the .env file exists
if (!file_exists($envPath)) {
    die(".env file doesn't exist. Please create a new one.");
} else {
    // Load the .env file
    $dotenv = Dotenv::createImmutable(dirname($envPath));  // Use the correct directory for the .env file
    $dotenv->load();

    // Access your environment variables
    $db_host = $_ENV['DB_HOST'] ?? 'localhost';  // Provide default values if variables are not set
    $db_user = $_ENV['DB_USERNAME'] ?? 'root';
    $db_pass = $_ENV['DB_PASSWORD'] ?? '';
    $db_name = $_ENV['DB_NAME'] ?? 'todo';

    // Establish a connection to the database
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    // Check the database connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // If the connection is successful
    echo "Connected to the database successfully!";
}
