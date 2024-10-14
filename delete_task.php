<?php
session_start();
require_once('inc/header.php');
require_once('db_connection_handler.php'); 





if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $task_id = intval($_GET['id']); 
   
    $query = "DELETE FROM tasks WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);


    mysqli_stmt_bind_param($stmt, 'i', $task_id);


    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success_delete_task']  = "Task deleted successfully.";
    } else {
        $_SESSION['errors']['db_error'] = "Failed to delete task: " . mysqli_error($conn);
    }


    mysqli_stmt_close($stmt);
} else {
    $_SESSION['errors']['invalid_id'] = "Invalid task ID.";
}


header('Location: list_task.php');
exit();
?>
