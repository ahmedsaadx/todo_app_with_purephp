<?php
session_start();
require_once('../models/connector/handler.php');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header('location: ../index.php?page=signup.php ');
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
            $_SESSION["errors_signup"]["password_limit_charaters"] = "Password must be at least 8 characters";   
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
        $check_user_exists_query = "SELECT email FROM users WHERE email = :email";
        $stmt_check_exists = $pdo->prepare($check_user_exists_query);
        $stmt_check_exists->bindParam(':email', $email);
        $stmt_check_exists->execute();

        if ($stmt_check_exists->rowCount() > 0) {
            $_SESSION["errors_signup"]["email_exists"] = "Email is already registered. Please use a different email.";
            header('location: ../index.php?page=signup');
            exit;
        } else {
            $insert_user_query = "INSERT INTO users (`name`, `email`, `password`) VALUES (:name, :email, :hash_password)";
            $stmt = $pdo->prepare($insert_user_query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':hash_password', $hash_password);
            if ($stmt->execute()) {
                $_SESSION['signup_success'] = 'Sign up successful! you can now sign in . Please go to the <a href="../index.php?page=login">login page</a>. ';
                header('location: ../index.php?page=signup');
                exit;
            } else {
                $_SESSION["errors_signup"]["db_error"] = "Error signing up, please try again.";
                header('location: ../index.php?page=signup');
                exit;
            }
        }
    } else {
        header('location: ../index.php?page=signup');
        exit;
    }
}

function test_input($data) {
   return htmlspecialchars(stripslashes(trim($data)));
}