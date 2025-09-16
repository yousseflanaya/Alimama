<?php
session_start();
if (!isset($_SESSION['utilisateur'])) {
    header('Location: connexion.php');
    exit;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AliMama</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f8fa;
        }

        #hero {
            background: linear-gradient(to right, #e0f7fa, #ffffff);
            border-radius: 15px;
            padding: 60px 30px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.05);
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
        }

        .hero-text {
            font-size: 1.2rem;
            color: #555;
            margin-top: 1rem;
        }

        .btn-dark {
            background-color: #212529;
            border: none;
            padding: 12px 20px;
            font-size: 1rem;
        }

        .btn-dark:hover {
            background-color: #343a40;
        }

        .welcome-box {
            background: #fff;
            border-radius: 10px;
            padding: 20px 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <?php include 'include/nav2.php'; ?>
    <?php include 'include/condb.php'; ?>
    <div class="container py-4">
        <div class="welcome-box text-center">
            <h3>Welcome, <span class="text-primary">
                <?= htmlspecialchars($_SESSION['utilisateur']['login'] ?? 'User') ?>
            </span>!</h3>
            <p class="mb-0">We're glad to have you back. Let's get shopping!</p>
        </div>
        <div class="row align-items-center" id="hero">
            <div class="col-lg-6">
                <h1 class="hero-title">AliMama — Your One-Stop Online Shopping Destination!</h1>
                <p class="hero-text">
                    Discover a wide range of quality products at unbeatable prices.
                    Whether you're looking for fashion, electronics, home essentials, or gifts —
                    we've got you covered. Enjoy fast delivery, secure payments, and top-notch service.
                </p>
                <a href="shop.php" class="btn btn-dark mt-3">
                    Go to Shop <i class="fas fa-store ms-2"></i>
                </a>
            </div>
            <div class="col-lg-6 text-center d-none d-lg-block">
                <img src="images/shop.png" alt="Shopping" class="img-fluid" style="max-height: 300px;">
            </div>
        </div>
    </div>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
