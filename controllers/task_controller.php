<?php 
session_start();
require_once('../models/connector/handler.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('location: index?page=create_task');
    exit();
} else {
    $task_name = trim($_POST["task_title"]);
    $task_description = trim($_POST["task_description"]);
    $task_date = $_POST["due_date"];
    $current_date = date('Y-m-d'); 
    $_SESSION['errors'] = [];
    if (empty($task_name)) {
        $_SESSION['errors']['task_name_required'] = "Task name is required.";
    } else {
        $task_name = input_sanitization($task_name);
        if (strlen($task_name) > 50) {
            $_SESSION['errors']['task_name_length'] = "Task name must be under 50 characters.";
        }
    }
    if (empty($task_description)) {
        $_SESSION['errors']['task_description_required'] = "Task description is required.";
    } else {
        $task_description = input_sanitization($task_description);
        if (strlen($task_description) > 150) {
            $_SESSION['errors']['task_description_length'] = "Task description must be under 150 characters.";
        }
    }
    $current_date = date('Y-m-d');
    if (empty($task_date)) {
        $_SESSION['errors']['task_date_required'] = "Due date is required.";
    } elseif ($task_date <= $current_date) {
        $_SESSION['errors']['task_date_invalid'] = "Due date must be after $current_date.";
    }
    if (empty($_SESSION['errors'])) {
        $add_task_query = "INSERT INTO tasks (`name`, `description`, `due_date`) VALUES (:task_name, :task_description, :task_date)";
        $stmt = $pdo-> prepare($add_task_query);
        $stmt -> bindParam(':task_name',$task_name); 
        $stmt -> bindParam(':task_description',$task_description); 
        $stmt -> bindParam(':task_date',$task_date); 
        if ($stmt->execute()) {
            $_SESSION['success'] = "Task added successfully!";
        } else {
            $_SESSION['errors']['db_error'] = "Failed to add task: " ;
        }
        header('location: ../index.php?page=create_task');
        exit();
    } else {
        header('location: ../index.php?page=create_task');
        exit();
    }
}

function input_sanitization($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}
