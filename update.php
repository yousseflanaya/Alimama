<?php
session_start();
require_once 'include/condb.php';

foreach ($_POST['quantities'] as $id => $qty) {
    $stmt = $pdo->prepare("SELECT stock FROM produit WHERE id = ?");
    $stmt->execute([$id]);
    $stock = $stmt->fetchColumn();
    if ($stock !== false && $qty > 0 && $qty <= $stock) {
        $_SESSION['cart'][$id] = intval($qty); 
    }
}

header('Location: cart.php'); 
exit;
