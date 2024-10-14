<?php
session_start();
require_once('inc/header.php');
require_once('db_connection_handler.php'); 

// Define input sanitization function
function input_sanitization($input) {
    return trim(htmlspecialchars($input));
}

// Check if the task ID is valid
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
        // Get form data and sanitize inputs
        $task_name = $_POST['task_title'];
        $task_description = $_POST['task_description'];
        $due_date = $_POST['due_date'];
        $status = $_POST['status'];
        
        // Initialize an error array
        $_SESSION['errors'] = [];

        // Validate task title
        if (empty($task_name)) {
            $_SESSION['task_errors']['task_name_required'] = "Task name is required.";
        } else {
            $task_name = input_sanitization($task_name);
            if (strlen($task_name) > 50) {
                $_SESSION['task_errors']['task_name_length'] = "Task name must be under 50 characters.";
            }
        }

        // Validate task description
        if (empty($task_description)) {
            $_SESSION['task_errors']['task_description_required'] = "Task description is required.";
        } else {
            $task_description = input_sanitization($task_description);
            if (strlen($task_description) > 150) {
                $_SESSION['task_errors']['task_description_length'] = "Task description must be under 150 characters.";
            }
        }

        // Validate due date: check if it's in the future
        $current_date = date('Y-m-d');
        if ($due_date <= $current_date) {
            $_SESSION['task_errors']['due_date_invalid'] = "Due date must be after the $current_date.";
        }
        $valid_statuses = ['pending', 'in-progress', 'completed'];
        if (!in_array($status, $valid_statuses)) {
            $_SESSION['task_errors']['invalid_status'] = "Invalid task status.";
        }

        // If no errors, proceed with the update
        if (empty($_SESSION['task_errors'])) {
            // Update query with placeholders including the updated_at field
            $update_query = "UPDATE tasks SET name = ?, description = ?, due_date = ?, status = ?, updated_at = ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $update_query);
    
            // Get current timestamp
            $updated_at = date('Y-m-d H:i:s'); // Current timestamp
    
            // Bind the parameters (s = string, i = integer)
            mysqli_stmt_bind_param($stmt, 'sssssi', $task_name, $task_description, $due_date, $status, $updated_at, $task_id);
    
            // Execute the statement
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION["update_task"] = "Task updated successfully.";
                header("Location: list_task.php");
                exit();
            } else {
                $_SESSION['errors']['db_error'] = "Error updating task: " . mysqli_error($conn);
            }
        }

        // If there are validation errors, redirect back to the form
        if (!empty($_SESSION['errors'])) {
            header("Location: update_task.php?id=$task_id");
            exit();
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

                        <!-- Display error messages -->
                        <?php if (!empty($_SESSION['task_errors'])): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php foreach ($_SESSION['task_errors'] as $error): ?>
                                        <li><?php echo $error; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

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
                            <div class="mb-3">
                            <label for="taskStatus" class="form-label">Task Status</label>
                            <select class="form-control" id="taskStatus" name="status" required>
                            <option value="pending" <?php echo ($task['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                            <option value="in-progress" <?php echo ($task['status'] == 'in-progress') ? 'selected' : ''; ?>>In Progress</option>
                            <option value="completed" <?php echo ($task['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                            </select>
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

<?php
if (isset($_SESSION['task_errors'])){
    unset($_SESSION['task_errors']);
}

