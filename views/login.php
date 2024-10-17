<?php 
?>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Login</h5>
                            <?php if (isset($_SESSION['sign_in_error']) && !empty($_SESSION['sign_in_error'])): ?>
                                <div class="alert alert-danger">
                                    <?php echo htmlspecialchars($_SESSION['sign_in_error']) ;  unset($_SESSION['sign_in_error']);?>
                                </div>
                                <?php endif; ?>
                            
                    <form action="../controllers/login_validation.php" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Login</button>
                            <a href="index?page=signup" class="btn btn-secondary">Sign Up</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>




