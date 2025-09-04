<?php
session_start();
require_once('files/functions.php');



// Collect inputs first
$action = $_POST['action'] ?? '';
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// ------------------- LOGIN -------------------
if ($action === 'login') {
    if ($email === '' || $password === '') {
        $_SESSION['error'] = "Email and password are required.";
        header("Location: login.php");
        exit;
    }

    $stmt = $conn->prepare("SELECT id, first_name, last_name, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            loginUser($user); // assumes this function sets $_SESSION['user_id'], etc.
            $_SESSION['success'] = "Welcome back, {$user['first_name']}!";
            header("Location: account_orders.php");
            exit;
        } else {
            $_SESSION['error'] = "Incorrect password.";
            header("Location: login.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "No account found with that email.";
        header("Location: login.php");
        exit;
    }
}

$_SESSION['error'] = "Invalid action.";
header("Location: login.php");
exit;
