<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>todo app</title> <!-- Add a title for the page -->
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto"> <!-- Left-aligned items -->
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="list_task.php">Tasks</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="create_task.php">Create Task</a>
                </li>
            </ul>
            <ul class="navbar-nav"> <!-- Right-aligned items -->
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a> <!-- Link to Login page -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="signup.php">Signup</a> <!-- Link to Signup page -->
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Your content here -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> <!-- Bootstrap JS -->
</body>
</html>
