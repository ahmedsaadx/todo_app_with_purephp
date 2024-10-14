<?php 
require_once('../db_connection_handler.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('location: ../create_task.php');
    exit();
} else {
    $task_name = trim($_POST["task_title"]);
    $task_description = trim($_POST["task_description"]);
    $task_date = $_POST["due_date"];
    $current_date = date('Y-m-d'); // Get current date

    // Initialize an empty array to store errors
    $_SESSION['errors'] = [];

    // Task name validation
    if (empty($task_name)) {
        $_SESSION['errors']['task_name_required'] = "Task name is required.";
    } else {
        $task_name = input_sanitization($task_name);
        if (strlen($task_name) > 50) {
            $_SESSION['errors']['task_name_length'] = "Task name must be under 50 characters.";
        }
    }

    // Task description validation
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
        $add_task_query = "INSERT INTO tasks (`name`, `description`, `due_date`) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $add_task_query);
        mysqli_stmt_bind_param($stmt, 'sss', $task_name, $task_description, $task_date);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "Task added successfully!";
        } else {
            $_SESSION['errors']['db_error'] = "Failed to add task: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);

        header('location: ../create_task.php');
        exit();
    } else {
        header('location: ../create_task.php');
        exit();
    }
}

// Function to sanitize user input
function input_sanitization($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}
