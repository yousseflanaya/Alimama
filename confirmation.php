<?php
session_start();
require_once 'include/condb.php';

$cart = $_SESSION['cart'] ?? [];
$user = $_SESSION['utilisateur'] ?? null;
$total = 0;
$isValid = true;

if (!$user) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adresse = $_POST['adresse'] ?? '';
    $carte = $_POST['carte'] ?? '';
    $typeCarte = $_POST['type_carte'] ?? '';

    foreach ($cart as $productId => $quantity) {
        $stmt = $pdo->prepare("SELECT stock, prix, discount FROM produit WHERE id = ?");
        $stmt->execute([$productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product || $product['stock'] < $quantity) {
            $isValid = false;
            break;
        }

        $price = $product['prix'];
        $discount = $product['discount'] ?? 0;
        $discountedPrice = $price * (1 - $discount / 100);

        $total += $discountedPrice * $quantity;
    }

    if ($isValid) {
        foreach ($cart as $productId => $quantity) {
            $pdo->prepare("UPDATE produit SET stock = stock - ? WHERE id = ?")
                ->execute([$quantity, $productId]);
            $stmt = $pdo->prepare("SELECT prix, discount FROM produit WHERE id = ?");
            $stmt->execute([$productId]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            $price = $product['prix'];
            $discount = $product['discount'] ?? 0;
            $discountedPrice = $price * (1 - $discount / 100);
            $totalPrice = $discountedPrice * $quantity;
            $stmt = $pdo->prepare("INSERT INTO detail_commande (id_produit, quantite, prix_total, adresse, carte_bancaire, type_carte) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $productId,
                $quantity,
                $totalPrice,
                $adresse,
                $carte,
                $typeCarte
            ]);
        }

        $_SESSION['cart'] = [];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-icons/font/bootstrap-icons.css">
    <style>
        .order-confirmation-card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            border-radius: 8px;
        }
        .order-heading {
            color: #007bff;
        }
        .alert-custom {
            padding: 15px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
<?php include 'include/nav3.php'; ?>

<div class="container mt-5">
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <?php if ($isValid): ?>
            <div class="alert alert-success alert-custom">
                <h4 class="alert-heading order-heading">Order Confirmed!</h4>
                <p>Total Paid: <strong><?= number_format($total, 2) ?> DH</strong></p>
                <hr>
                <p class="mb-0">Thank you for your purchase. We hope to see you again soon!</p>
            </div>
            <a href="shop.php" class="btn btn-primary">Back to Shop</a>
        <?php else: ?>
            <div class="alert alert-danger alert-custom">
                <h4 class="alert-heading order-heading">Order Failed</h4>
                <p>One or more products in your cart no longer have sufficient stock.</p>
            </div>
            <a href="cart.php" class="btn btn-secondary">Back to Cart</a>
        <?php endif; ?>
    <?php else: ?>
        <div class="order-confirmation-card">
            <h2 class="order-heading">Confirm Your Order</h2>
            <form method="post">
                <div class="mb-4">
                    <label for="adresse" class="form-label">Delivery Address</label>
                    <textarea id="adresse" name="adresse" class="form-control" required placeholder="Enter your delivery address"></textarea>
                </div>
                <div class="mb-4">
                    <label for="type_carte" class="form-label">Card Type</label>
                    <select id="type_carte" name="type_carte" class="form-select" required>
                        <option value="">-- Select Card Type --</option>
                        <option value="Visa">Visa</option>
                        <option value="MasterCard">MasterCard</option>
                        <option value="American Express">American Express</option>
                        <option value="PayPal">PayPal</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="carte" class="form-label">Credit Card Number</label>
                    <input type="text" id="carte" name="carte" class="form-control" maxlength="20" required placeholder="Enter your credit card number">
                </div>
                
                <button type="submit" class="btn btn-success w-100">Confirm Purchase</button>
            </form>
        </div>
    <?php endif; ?>
</div>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
