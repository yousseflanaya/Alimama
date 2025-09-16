<?php
require_once 'include/condb.php';
if (!isset($_GET['id'])) {
    header('Location: shop.php');
    exit;
}
$id = (int) $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM produit WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_OBJ);

if (!$product) {
    echo "<h2 class='text-center text-danger mt-5'>Product not found.</h2>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product->libelle) ?> | AliMama</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-icons/font/bootstrap-icons.css">
    <style>
        .product-img {
            max-height: 400px;
            object-fit: cover;
            width: 100%;
            border-radius: 10px;
        }
        .original-price {
            text-decoration: line-through;
            color: gray;
            margin-right: 10px;
        }
    </style>
</head>
<body>
<?php include 'include/nav3.php'; ?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-6">
            <img src="<?= $product->image ?>" alt="<?= htmlspecialchars($product->libelle) ?>" class="product-img">
        </div>
        <div class="col-md-6">
            <h2><?= htmlspecialchars($product->libelle) ?></h2>
            <p class="lead"><?= htmlspecialchars($product->description) ?></p>
            <?php if ($product->discount): ?>
                <?php
                    $discounted = $product->prix - ($product->prix * $product->discount / 100);
                ?>
                <p class="fw-bold h4 text-success">
                    <span class="original-price"><?= number_format($product->prix, 2) ?> DH</span>
                    <?= number_format($discounted, 2) ?> DH
                    <span class="badge bg-danger ms-2">-<?= $product->discount ?>%</span>
                </p>
            <?php else: ?>
                <p class="text-success fw-bold h4"><?= number_format($product->prix, 2) ?> DH</p>
            <?php endif; ?>

            <p>Stock: <?= $product->stock ?></p>

            <form action="add_to_cart.php" method="post">
                <input type="hidden" name="id" value="<?= $product->id ?>">
                <input type="number" name="quantity" min="1" max="<?= $product->stock ?>" value="1" class="form-control w-25 mb-3">
                <button type="submit" class="btn btn-primary">Add to Cart</button>
            </form>
        </div>
    </div>
</div>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
