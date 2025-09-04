<?php
session_start();
require_once('files/functions.php');

// Validate ID
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($product_id <= 0) {
    $_SESSION['message'] = "Invalid product selected.";
    header("Location: shop.php");
    exit;
}

// Get quantity
$quantity = isset($_GET['quantity']) ? intval($_GET['quantity']) : 1;
if ($quantity <= 0) $quantity = 1;

// Fetch product
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if (!$product) {
    $_SESSION['message'] = "Product not found.";
    header("Location: shop.php");
    exit;
}

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add or update product in cart
if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]['quantity'] += $quantity;
} else {
    $_SESSION['cart'][$product_id] = [
        'id' => $product['id'],
        'name' => $product['name'],
        'price' => $product['selling_price'],
        'photos' => $product['photos'],
        'quantity' => $quantity
    ];
}

$_SESSION['message'] = $product['name'] . " added to cart.";
header("Location: shop.php");
exit;
?>
