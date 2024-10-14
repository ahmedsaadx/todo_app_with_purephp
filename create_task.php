<?php
session_start();

require_once('db_connection_handler.php');
require_once('inc/header.php');


?>

<body>
    <div class="container">
      <h1 class="mt-5">Create a New Task</h1>
      <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
          <ul>
            <?php foreach ($_SESSION['errors'] as $error): ?>
              <li><?php echo $error; ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
      <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
          <?php echo $_SESSION['success']; ?>
        </div>
      <?php endif; ?>
      
      <form action="actions/task_validation.php" method="POST" class="mt-3">
        <div class="mb-3">
          <label for="taskTitle" class="form-label">Task Title</label>
          <input type="text" class="form-control" id="taskTitle" name="task_title">
        </div>

        <div class="mb-3">
          <label for="taskDescription" class="form-label">Task Description</label>
          <textarea class="form-control" id="taskDescription" name="task_description" rows="3" ></textarea>
        </div>

        <div class="mb-3">
          <label for="taskDueDate" class="form-label">Due Date</label>
          <input type="date" class="form-control" id="taskDueDate" name="due_date" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Task</button>
      </form>
    </div>
</body>
<?php
if (isset($_SESSION['success'])){
    unset($_SESSION['success']);
}
if (isset($_SESSION['errors'])){
    unset($_SESSION['errors']);
}
?>
