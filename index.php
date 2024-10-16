<?php
session_start();
require_once('models/connector/handler.php');
$page = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : '';

include_once('assets/header.php');

try {
    $view = match ($page) {
        'create_task' => 'views/create_task.php',
        'list_task' => 'views/list_task.php',
        'delete_task' => 'views/delete_task.php',
        'login' => 'views/login.php',
        'signup' => 'views/signup.php',
        'update_task' => 'views/update_task.php',
        // 'task_controller' => 'controllers/task_controller.php',
        // default => 'index.php', 
    };

    include $view;
} catch (Throwable $e) {
    // include 'index.php'; 
}










