<?php
require 'vendor/autoload.php';

use Dotenv\Dotenv;

if(!file_exists(__DIR__ . '/.env') ){
	die(".env file don't exists . please create new env ");
}else{
  // Load .env file
  $dotenv = Dotenv::createImmutable(__DIR__);
  $dotenv->load();

  // Access your environment variables
  $db_host=$_ENV['DB_HOST'];
  $db_pass=$_ENV['DB_PASSWORD'] ;
  $db_user=$_ENV['DB_USERNAME'];
  $db_name=$_ENV['DB_NAME'];
  $conn = mysqli_connect($db_host,$db_user,$db_pass,$db_name);

  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

  }
