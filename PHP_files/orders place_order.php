<?php
session_start();
require '../config/db.php';

$user_id = $_SESSION['user_id'];
$sql = "INSERT INTO orders (user_id, order_date) VALUES (?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$order_id = $conn->insert_id;

$sql = "SELECT * FROM cart WHERE user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $product_id = $row['product_id'];
    $quantity = $row['quantity'];
    $sql = "INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)";
    $stmt2 = $conn->prepare($sql);
    $stmt2->bind_param("iii", $order_id, $product_id, $quantity);
    $stmt2->execute();
}

$conn->query("DELETE FROM cart WHERE user_id=$user_id");
echo "Order placed!";
?>
