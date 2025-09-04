<?php
session_start();
require_once('files/functions.php');


$product_id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($product_id > 0 && isset($_SESSION['cart'][$product_id])) {
    unset($_SESSION['cart'][$product_id]);
    $_SESSION['message'] = "Product removed from cart.";
} else {
    $_SESSION['message'] = "Product not found in cart.";
}

header("Location: shop.php"); // Or redirect to previous page
exit;
