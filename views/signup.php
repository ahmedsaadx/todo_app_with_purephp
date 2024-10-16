<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Signup</title>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Create an Account</h2>
    <?php if (isset($_SESSION['errors_signup']) && !empty($_SESSION['errors_signup'])): ?>
        <div class="alert alert-danger">
          <ul>
            <?php foreach ($_SESSION['errors_signup'] as $error): ?>
              <li><?php echo $error; ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
      <?php if (isset($_SESSION['signup_success'])): ?>
        <div class="alert alert-success">
          <?php echo $_SESSION['signup_success']; ?>
        </div>
      <?php endif; ?>
    <form action="../actions/signup_validation.php" method="POST"> 
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" >
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" >
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" >
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" >
        </div>
        <button type="submit" class="btn btn-primary">Sign Up</button>
    </form>
    <p class="mt-3 text-center">Already have an account? <a href="login.php">Login here</a>.</p> 
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>

<?php 
if(isset($_SESSION['errors_signup'])){
    unset($_SESSION['errors_signup']);
}
if(isset($_SESSION['signup_success'])){
    unset($_SESSION['signup_success']);
}

