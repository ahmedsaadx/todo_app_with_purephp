<?php
session_start();
require_once('models/connector/handler.php');
require_once('controllers/auth.php');
include_once('assets/header.php');
$page = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : 'home'; // Default to 'home' or your default page

try {

    $valid_pages = [
        'home' => 'views/home.php', 
        'create_task' => 'views/create_task.php',
        'list_task' => 'views/list_task.php',
        'delete_task' => 'views/delete_task.php',
        'login' => 'views/login.php',
        'signup' => 'views/signup.php',
        'update_task' => 'views/update_task.php',
        'signout' => 'views/signout.php'
    ];

    if (array_key_exists($page, $valid_pages)) {
        include $valid_pages[$page];
    } else {
        throw new Exception('Page not found');
    }
} catch (Throwable $e) {
    echo "<h1>Error</h1><p>{$e->getMessage()}</p>"; 
}










