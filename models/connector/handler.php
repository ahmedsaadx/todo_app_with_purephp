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
    $db_pass = $_ENV['DB_PASSWORD'] ?? '123456';
    $db_name = $_ENV['DB_NAME'] ?? 'todo';
    $dsn = "mysql:host=$db_host;dbname=$db_name;charset=UTF8";

    try {
	$pdo = new PDO($dsn, $db_user, $db_pass);

	if (!$pdo) {
		echo "Can't Connect to the $db_name database !";
	}   
    } catch (PDOException $e) {
	echo $e->getMessage();
    }

}
