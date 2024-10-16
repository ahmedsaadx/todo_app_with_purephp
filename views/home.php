<?php
// if (!isset($_SESSION['user_id'])) {
//     header('Location: index.php?page=login');
//     exit;
// }

echo "<h1>Welcome to the Home Page</h1>";
echo "<p>Hello, " . htmlspecialchars($_SESSION["user_name"]) . "!</p>";
?>