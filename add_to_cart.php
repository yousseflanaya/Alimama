<?php
session_start();
require_once 'include/condb.php';

$id = $_POST['id'];
$quantity = intval($_POST['quantity']);

$stmt = $pdo->prepare("SELECT * FROM produit WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if ($product && $product['stock'] >= $quantity) {
    if (!isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = 0;
    }
    $_SESSION['cart'][$id] += $quantity;
}

header('Location: shop.php');
exit;
