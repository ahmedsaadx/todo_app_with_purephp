<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Todo App</title>
</head>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <?php if (isset($_SESSION['user_id'])): ?>
    <!-- User is logged in, show task management links and signout -->
         <ul class="navbar-nav me-auto"> 
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php?page=home">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=list_task">Tasks</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=create_task">Create Task</a>
            </li>
        </ul>
        <ul class="navbar-nav"> 
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=signout">Signout</a> 
            </li>
        </ul>
        <?php else: ?>
        <ul class="navbar-nav"> 
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=login">Login</a> 
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=signup">Signup</a> 
            </li>
        </ul>

<?php endif; ?>

        </div>
    </div>
</nav>
<!-- Your content here -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> <!-- Bootstrap JS -->

