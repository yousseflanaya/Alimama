<?php
session_start();
require_once 'include/condb.php';
$selectedCategory = isset($_GET['cat']) ? (int)$_GET['cat'] : null;
$catStmt = $pdo->query("SELECT * FROM categorie ORDER BY libelle");
$categories = $catStmt->fetchAll(PDO::FETCH_OBJ);
if ($selectedCategory) {
    $stmt = $pdo->prepare("SELECT * FROM produit WHERE id_categorie = ? ORDER BY date_creation DESC");
    $stmt->execute([$selectedCategory]);
} else {
    $stmt = $pdo->query("SELECT * FROM produit ORDER BY date_creation DESC");
}
$products = $stmt->fetchAll(PDO::FETCH_OBJ);
$bestStmt = $pdo->query("
    SELECT p.*, SUM(dc.quantite) AS total_sold
    FROM detail_commande dc
    JOIN produit p ON p.id = dc.id_produit
    GROUP BY dc.id_produit
    ORDER BY total_sold DESC
    LIMIT 5
");
$bestSellers = $bestStmt->fetchAll(PDO::FETCH_OBJ);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AliMama | Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body { background: #f8f9fa; }
        .product-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }
        .product-card:hover {
            transform: translateY(-8px);
        }
        .product-image {
            height: 220px;
            object-fit: cover;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .sidebar .list-group-item.active {
            background-color: #007bff;
            color: #fff;
            border: none;
        }
    </style>
</head>
<body>

<?php include 'include/nav3.php'; ?>

<div class="container py-4">
    <div class="row">
        <div class="col-md-3 sidebar">
            <h5 class="mb-3">Categories</h5>
            <div class="list-group mb-4">
                <a href="shop.php" class="list-group-item <?= !$selectedCategory ? 'active' : '' ?>">All Products</a>
                <?php foreach ($categories as $cat): ?>
                    <a href="shop.php?cat=<?= $cat->id ?>" class="list-group-item <?= $selectedCategory == $cat->id ? 'active' : '' ?>">
                        <?= htmlspecialchars($cat->libelle) ?>
                    </a>
                <?php endforeach; ?>
            </div>
            <h5 class="mb-3">Best Sellers</h5>
            <div class="card mb-4">
                <ul class="list-group list-group-flush">
                    <?php foreach ($bestSellers as $item): ?>
                        <li class="list-group-item d-flex align-items-center">
                            <a href="product_detail.php?id=<?= $item->id ?>">
                                <img src="<?= $item->image ?>" alt="<?= $item->libelle ?>"class="me-2" style="width: 50px; height: 50px; object-fit: cover;">
                            </a>
                            <div>
                                <a href="product_detail.php?id=<?= $item->id ?>"class="text-decoration-none">
                                    <strong><?= $item->libelle ?></strong>
                                </a><br>
                                <span class="text-muted"><?= number_format($item->prix,2) ?> DH</span>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            <h3 class="mb-4">Products</h3>
            <div class="row">
                <?php if (count($products) > 0): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card product-card h-100">
                                <a href="product_detail.php?id=<?= $product->id ?>">
                                    <img src="<?= $product->image ?>"class="product-image card-img-top" alt="<?= $product->libelle ?>">
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title"><?= $product->libelle ?></h5>
                                    <p class="card-text text-muted"><?= substr($product->description, 0, 80) . '...' ?></p>
                                    <?php if (!empty($product->discount)): ?>
                                        <p class="mb-1">
                                            <span class="text-danger fw-bold"><?= number_format($product->prix * (1 - $product->discount / 100), 2) ?> DH</span>
                                            <span class="text-muted text-decoration-line-through"><?= number_format($product->prix, 2) ?> DH</span>
                                            <span class="badge bg-warning text-dark ms-1">-<?= $product->discount ?>%</span>
                                        </p>
                                    <?php else: ?>
                                        <p class="fw-bold"><?= number_format($product->prix, 2) ?> DH</p>
                                    <?php endif; ?>
                                    <p>Stock: <?= $product->stock ?></p>
                                </div>
                                <div class="card-footer">
                                    <form action="add_to_cart.php" method="post">
                                        <input type="hidden" name="id" value="<?= $product->id ?>">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <input type="number" name="quantity" value="1" min="1" max="<?= $product->stock ?>" class="form-control w-25">
                                            <button type="submit" class="btn btn-sm btn-primary">Add</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12"><p class="text-muted">No products found in this category.</p></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
