<?php
session_start();
require '../config/db.php';

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];

$sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE quantity = quantity + ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiii", $user_id, $product_id, $quantity, $quantity);
$stmt->execute();

echo "Added to cart";
?>