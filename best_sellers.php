<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-icons/font/bootstrap-icons.css">
    <title>best seller</title>
</head>
<body>
<?php
$stmt = $pdo->query("
    SELECT p.*, SUM(dc.quantite) AS total_sold, p.prix AS original_price
    FROM detail_commande dc
    INNER JOIN produit p ON p.id = dc.id_produit
    GROUP BY p.id
    ORDER BY total_sold DESC
    LIMIT 5
");
$best_sellers = $stmt->fetchAll(PDO::FETCH_OBJ);
?>
<div class="col-md-4">
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <strong>Best Sellers</strong>
        </div>
        <ul class="list-group list-group-flush">
            <?php foreach ($best_sellers as $item): ?>
                <?php
                    $discounted_price = $item->prix;
                    if (!empty($item->discount) && $item->discount > 0) {
                        $discounted_price = $item->prix - ($item->prix * ($item->discount / 100));
                    }
                ?>
                <li class="list-group-item d-flex align-items-center">
                    <?php if (!empty($item->image)): ?>
                        <img src="<?= htmlspecialchars($item->image) ?>"
                             alt="<?= htmlspecialchars($item->libelle) ?>"
                             class="me-3"
                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                    <?php else: ?>
                        <div class="me-3" style="width: 50px; height: 50px; background-color: #f0f0f0; border-radius: 5px;"></div>
                    <?php endif; ?>
                    <div>
                        <div class="fw-semibold"><?= htmlspecialchars($item->libelle) ?></div>
                        <div class="text-muted small">
                            <span class="d-block">Price: <?= number_format($discounted_price, 2) ?> DH</span>
                            <?php if (!empty($item->discount) && $item->discount > 0): ?>
                                <span class="text-danger small text-decoration-line-through">
                                    <?= number_format($item->original_price, 2) ?> DH
                                </span>
                                <span class="text-success small">(Discount Applied!)</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>