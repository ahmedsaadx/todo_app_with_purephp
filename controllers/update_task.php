<?php
session_start();
require_once('../models/connector/handler.php');
require_once('auth.php');
route_protected();
function input_sanitization($input) {
    return trim(htmlspecialchars($input));
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $task_id = intval($_GET['id']); 
    $user_id= $_SESSION['user_id'];
    $select_query = "SELECT * FROM tasks WHERE id = :task_id AND user_id = :user_id";
    $stmt = $pdo->prepare($select_query);
    $stmt->bindParam(':task_id', $task_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $task = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$task) {
        die("Task not found.");
    }
    
    // Check if the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get form data and sanitize inputs
        $task_name = input_sanitization($_POST['task_title']);
        $task_description = input_sanitization($_POST['task_description']);
        $due_date = $_POST['due_date'];
        $status = $_POST['status'];
        
        // Initialize an error array
        $_SESSION['task_errors'] = [];

        // Validate task title
        if (empty($task_name)) {
            $_SESSION['task_errors']['task_name_required'] = "Task name is required.";
        } elseif (strlen($task_name) > 50) {
            $_SESSION['task_errors']['task_name_length'] = "Task name must be under 50 characters.";
        }

        // Validate task description
        if (empty($task_description)) {
            $_SESSION['task_errors']['task_description_required'] = "Task description is required.";
        } elseif (strlen($task_description) > 150) {
            $_SESSION['task_errors']['task_description_length'] = "Task description must be under 150 characters.";
        }

        // Validate due date: check if it's in the future
        $current_date = date('Y-m-d');
        if ($due_date <= $current_date) {
            $_SESSION['task_errors']['due_date_invalid'] = "Due date must be after the $current_date.";
        }
        
        // Validate status
        $valid_statuses = ['pending', 'in-progress', 'completed'];
        if (!in_array($status, $valid_statuses)) {
            $_SESSION['task_errors']['invalid_status'] = "Invalid task status.";
        }

        // If no errors, proceed with the update
        if (empty($_SESSION['task_errors'])) {
            $update_query = "UPDATE tasks SET name = :task_name, description = :task_description, due_date = :due_date, status = :status, updated_at = :updated_at WHERE id = :task_id";
            $stmt = $pdo->prepare($update_query);
            $updated_at = date('Y-m-d H:i:s'); // Current timestamp
            $stmt->bindParam(':task_name', $task_name);
            $stmt->bindParam(':task_description', $task_description);
            $stmt->bindParam(':due_date', $due_date);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':updated_at', $updated_at);
            $stmt->bindParam(':task_id', $task_id, PDO::PARAM_INT);
    
            if ($stmt->execute()) {
                $_SESSION["update_task"] = "Task updated successfully.";
                header("Location: ../index.php?page=list_task");
                exit();
            } else {
                $_SESSION['errors']['db_error'] = "Error updating task.";
            }
        }

        // If there are validation errors, redirect back to the form
        if (!empty($_SESSION['task_errors'])) {
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
// Clear task errors after displaying the form
if (isset($_SESSION['task_errors'])){
    unset($_SESSION['task_errors']);
}
?>
