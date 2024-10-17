<?php
route_protected();

echo "<h1>Welcome to the Home Page</h1>";
echo "<p>Hello, " . htmlspecialchars($_SESSION["user_name"]) . "!</p>";
?>