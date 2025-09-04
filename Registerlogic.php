<?php
session_start();
require_once('files/functions.php');

// Collect and sanitize inputs
$first_name = trim($_POST['first_name'] ?? '');
$last_name = trim($_POST['last_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$password = $_POST['password'] ?? '';
$password_confirmation = $_POST['password_confirmation'] ?? '';
$action = $_POST['action'] ?? '';

// ------------------- REGISTER -------------------
if ($action === 'register') {
    // Validate email
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['reg_error'] = "Please enter a valid email address.";
        header("Location: login.php");
        exit;
    }

    // Check if email exists
    if (emailExists($email)) {
        $_SESSION['reg_error'] = "Email is already registered. Try logging in.";
        header("Location: login.php");
        exit;
    }

    // Validate required fields
    if ($first_name === '' || $last_name === '' || $phone === '' || $password === '' || $password_confirmation === '') {
        $_SESSION['reg_error'] = "All fields are required.";
        header("Location: login.php");
        exit;
    }

    // Check if passwords match
    if ($password !== $password_confirmation) {
        $_SESSION['reg_error'] = "Passwords do not match.";
        header("Location: login.php");
        exit;
    }

    // Hash password and insert into DB
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, phone, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $first_name, $last_name, $email, $phone, $hashed_password);

    if ($stmt->execute()) {
        $_SESSION['reg_success'] = "Registration successful! You can now sign in.";
    } else {
        $_SESSION['reg_error'] = "Registration failed. Please try again later.";
    }

    $stmt->close();
    header("Location: login.php");
    exit;
}

$_SESSION['reg_error'] = "Invalid request.";
header("Location: login.php");
exit;
