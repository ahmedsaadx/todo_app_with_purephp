<?php
session_start();
require_once('inc/header.php');
require_once('db_connection_handler.php'); 

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $task_id = intval($_GET['id']); 

    // Fetch the existing task data to pre-fill the form
    $select_query = "SELECT * FROM tasks WHERE id = ?";
    $stmt = mysqli_prepare($conn, $select_query);
    mysqli_stmt_bind_param($stmt, 'i', $task_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $task = mysqli_fetch_assoc($result);

    if (!$task) {
        die("Task not found.");
    }
    
    // Check if the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $task_name = $_POST['task_title'];
        $task_description = $_POST['task_description'];
        $due_date = $_POST['due_date'];

        // Validate due date: check if it's in the future
        $current_date = date('Y-m-d');
        if ($due_date <= $current_date) {
            echo "<div class='alert alert-danger'>Due date must be after $current_date.</div>";
        } else {
            // Update query with placeholders including the updated_at field
            $update_query = "UPDATE tasks SET name = ?, description = ?, due_date = ?, updated_at = ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $update_query);

            // Get current timestamp
            $updated_at = date('Y-m-d H:i:s'); // Current timestamp

            // Bind the parameters (s = string, i = integer)
            mysqli_stmt_bind_param($stmt, 'ssssi', $task_name, $task_description, $due_date, $updated_at, $task_id);

            // Execute the statement
            if (mysqli_stmt_execute($stmt)) {
                // Success, redirect to task list
                $_SESSION["update_task"] = "Task updated successfully .";
                header("Location: list_task.php");
                exit();
            } else {
                echo "Error updating task: " . mysqli_error($conn);
            }
        }
    }
} else {
    die("Invalid Task ID.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Update Task</h5>
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="taskTitle" class="form-label">Task Title</label>
                                <input type="text" class="form-control" id="taskTitle" name="task_title" value="<?php echo htmlspecialchars($task['name']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="taskDescription" class="form-label">Task Description</label>
                                <textarea class="form-control" id="taskDescription" name="task_description" rows="3" required><?php echo htmlspecialchars($task['description']); ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="dueDate" class="form-label">Due Date</label>
                                <input type="date" class="form-control" id="dueDate" name="due_date" value="<?php echo htmlspecialchars($task['due_date']); ?>" required>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-block">Update Task</button>
                                <a href="list_task.php" class="btn btn-secondary btn-block">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
