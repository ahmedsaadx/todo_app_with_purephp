<?php
session_start();
require_once('../database/connector/handler.php');
require_once('../inc/header.php');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header('location: ../pages/signup.php ');
    exit;
    }else{
    if (empty($_POST["username"])) {
        $_SESSION["errors_signup"]["signup_name_required"] = "Name is required";
    } else {
        $name = test_input($_POST["username"]);
        if (!preg_match("/^[a-zA-Z-' ]+$/", $name)) {
            $_SESSION["errors_signup"]["signup_name_match_rules"] = "Only letters, hyphens, and white space are allowed";
        }
    }

    if (empty($_POST["email"])) {
        $_SESSION["errors_signup"]["email"] = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION["errors_signup"]["email"] = "Invalid email format";
        }
    }

    if (empty($_POST["password"])) {
        $_SESSION["errors_signup"]["password"] = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
        if(strlen($_POST["password"]) < 8){
            $_SESSION["errors_signup"]["password_limit_charaters"] = "Password must be  < 8 charater";   
        }else{
        $hash_password=password_hash($password,PASSWORD_BCRYPT);
        }
    }
    if (empty($_POST["confirm_password"])) {
        $_SESSION["errors_signup"]["confirmPassword"] = "Confirm password is required";
    } else {
        $confirm_password = test_input($_POST["confirm_password"]);
        if ($confirm_password !== $_POST["password"]) {
            $_SESSION["errors_signup"]["confirm_password"] = "Passwords must match";
        }
    }

    
    if (empty($_SESSION["errors_signup"])) {
        $_SESSION['signup_success']= 'sign up successfully';
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hash_password);
        if (mysqli_stmt_execute($stmt)) {
            echo "Signup successful!";
            header('location: ../pages/signup.php');
            exit;
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
        header('location: ../pages/signup.php');
        exit;
    }else{
        header('location: ../pages/signup.php');
        exit;
    }
}

function test_input($data) {
   return htmlspecialchars(stripslashes(trim($data)));
}