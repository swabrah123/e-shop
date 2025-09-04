<?php
session_start();
require_once('files/functions.php'); // $conn must be defined in this file

// Redirect back if cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $_SESSION['error_message'] = "Your cart is empty. Please add items before placing an order.";
    header("Location: checkout.php"); // go back to checkout page
    exit();
}

// Collect required data
$customer_id    = $_SESSION['user_id'] ?? 0;
$user_name      = ($_SESSION['first_name'] ?? '') . ' ' . ($_SESSION['last_name'] ?? '');
$order_status   = 'pending';
$shipping_json  = json_encode($_SESSION['shipping'] ?? []);
$cart_json      = json_encode($_SESSION['cart']);
$total_price    = 0;
$created_at     = date("Y-m-d H:i:s");

// Calculate total
foreach ($_SESSION['cart'] as $item) {
    $total_price += $item['price'] * $item['quantity'];
}

// Insert order
$stmt = $conn->prepare("
    INSERT INTO orders (customer_id, order_status, shipping_address, cart, user_name, total_price, created_at)
    VALUES (?, ?, ?, ?, ?, ?, ?)
");

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param(
    "issssds",
    $customer_id,
    $order_status,
    $shipping_json,
    $cart_json,
    $user_name,
    $total_price,
    $created_at
);

if ($stmt->execute()) {
    // ✅ Clear cart and shipping
    unset($_SESSION['cart']);
    unset($_SESSION['shipping']);

    // ✅ Redirect to complete page
    header("Location: checkout-complete.php");
    exit();
} else {
    // Handle error
    $_SESSION['error_message'] = "Order could not be submitted. Please try again.";
    header("Location: checkout-complete.php");
    exit();
}
