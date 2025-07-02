<?php

session_start();
require_once 'config.php';

if (isset($_POST['register'])){
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm = isset($_POST['confirm']) ? trim($_POST['confirm']) : '';

    // Server-side empty field validation
    if ($username === '') {
        $_SESSION['register_error'] = 'Please enter a username.';
        $_SESSION['active_form'] = 'register';
        header("Location: signup.php");
        exit();
    }
    if ($email === '') {
        $_SESSION['register_error'] = 'Please enter your email address.';
        $_SESSION['active_form'] = 'register';
        header("Location: signup.php");
        exit();
    }
    if ($password === '') {
        $_SESSION['register_error'] = 'Please enter a password.';
        $_SESSION['active_form'] = 'register';
        header("Location: signup.php");
        exit();
    }
    if ($confirm === '') {
        $_SESSION['register_error'] = 'Please confirm your password.';
        $_SESSION['active_form'] = 'register';
        header("Location: signup.php");
        exit();
    }

    if ($password !== $confirm) {
        $_SESSION['register_error'] = 'Passwords do not match.';
        $_SESSION['active_form'] = 'register';
        header("Location: signup.php");
        exit();
    }

    // Password hashing
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email or username already exists
    $checkEmail = $conn->query("SELECT email FROM users WHERE email = '$email'");
    $checkUsername = $conn->query("SELECT username FROM users WHERE username = '$username'");
    $emailExists = $checkEmail->num_rows > 0;
    $usernameExists = $checkUsername->num_rows > 0;

    if ($emailExists) {
        $_SESSION['register_error'] = 'This email is already registered.';
        $_SESSION['active_form'] = 'register';
    } elseif ($usernameExists) {
        $_SESSION['register_error'] = 'This username is already taken.';
        $_SESSION['active_form'] = 'register';
    } else {
        $conn->query("INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')");
        $_SESSION['register_success'] = 'Registration successful! Redirecting to login...';
    }

    header("Location: signup.php");
    exit();
}

if (isset($_POST['login'])){
    $login_id = isset($_POST['login_id']) ? trim($_POST['login_id']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Server-side empty field validation
    if ($login_id === '') {
        $_SESSION['login_error'] = 'Username or email is required.';
        $_SESSION['active_form'] = 'login';
        header("Location: login.php");
        exit();
    }
    if ($password === '') {
        $_SESSION['login_error'] = 'Password is required.';
        $_SESSION['active_form'] = 'login';
        header("Location: login.php");
        exit();
    }

    // Check if email or username exists
    $result = $conn->query("SELECT * FROM users WHERE username = '$login_id' OR email = '$login_id'");
    if  ($result->num_rows > 0){
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])){
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];

            header("Location: home.php");
            exit();
        }
    }

    $_SESSION['login_error'] = 'Incorrect username/email or password. Please try again.';
    $_SESSION['active_form'] = 'login';
    header("Location: login.php");
    exit();
}


?>