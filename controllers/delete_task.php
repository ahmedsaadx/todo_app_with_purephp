<?php
session_start();
require_once('auth.php');
route_protected(); 
require_once('../models/connector/handler.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $task_id = intval($_GET['id']); 
    $user_id = $_SESSION['user_id']; 
    $query = "DELETE FROM tasks WHERE id = :task_id AND user_id = :user_id";
    $stmt = $pdo->prepare($query); 
    $stmt->bindParam(':task_id', $task_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
            $_SESSION['success_delete_task'] = "Task deleted successfully.";
        } else {
            $_SESSION['errors']['no_task_found'] = "No task found with this ID for this user.";
        }
    } else {
        $errorInfo = $stmt->errorInfo();
        $_SESSION['errors']['db_error'] = "Failed to delete task. Error: " . $errorInfo[2];
    }
} else {
    $_SESSION['errors']['invalid_id'] = "Invalid task ID.";
}
header('Location: ../index.php?page=list_task');
exit();
?>
