<?php
session_start();
require_once 'include/condb.php';

$cart = $_SESSION['cart'] ?? [];
$total = 0;
$items = [];

foreach ($cart as $id => $qty) {
    $stmt = $pdo->prepare("SELECT * FROM produit WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_OBJ);
    if ($product) {
        $discount = $product->discount ?? 0;
        $discountedPrice = $product->prix * (1 - $discount / 100);
        $lineTotal = $discountedPrice * $qty;

        $items[] = [
            'product' => $product,
            'quantity' => $qty,
            'discountedPrice' => $discountedPrice,
            'lineTotal' => $lineTotal
        ];

        $total += $lineTotal;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
<?php include 'include/nav3.php'; ?>

<div class="container mt-4">
    <h2>Your Cart</h2>

    <div class="row">]
        <div class="col-lg-8">
            <form action="update.php" method="post">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Original Price</th>
                            <th>Discount</th>
                            <th>Price After Discount</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['product']->libelle) ?></td>
                            <td><?= number_format($item['product']->prix, 2) ?> DH</td>
                            <td><?= $item['product']->discount ?? 0 ?>%</td>
                            <td><?= number_format($item['discountedPrice'], 2) ?> DH</td>
                            <td>
                                <input type="number" name="quantities[<?= $item['product']->id ?>]"
                                       value="<?= $item['quantity'] ?>" min="1"
                                       max="<?= $item['product']->stock ?>" class="form-control" style="width: 80px;">
                            </td>
                            <td><?= number_format($item['lineTotal'], 2) ?> DH</td>
                            <td>
                                <a href="remove.php?id=<?= $item['product']->id ?>" class="btn btn-sm btn-danger">Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </form>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <strong>Total</strong>
                </div>
                <div class="card-body">
                    <p class="fw-bold fs-5">Total: <?= number_format($total, 2) ?> DH</p>

                    <div class="d-flex gap-2">
                        <a href="confirmation.php" class="btn btn-success w-50">Checkout</a>
                        <button type="submit" class="btn btn-primary w-50">Update Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
