<?php
session_start();
require_once('auth.php');
route_protected();
require_once('../models/connector/handler.php');
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $task_id = intval($_GET['id']); 
    $user_id = $_SESSION['user_id'];
    $query = "DELETE FROM tasks WHERE id = :task_id and user_id = :user_id";
    $stmt = $pdo->prepare($query); 
    $stmt->bindParam(':task_id', $task_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        $_SESSION['success_delete_task'] = "Task deleted successfully.";
    } else {
         $_SESSION['errors']['db_error'] = "Failed to delete task.";
        }
} else {
    $_SESSION['errors']['invalid_id'] = "Invalid task ID.";
}
header('Location: ../index.php?page=list_task');
exit();
?>
