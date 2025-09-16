<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AliMama</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-icons/fonts/bootstrap-icons.woff2">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
        }

        #hero {
            background: linear-gradient(to right, #e0f7fa, #ffffff);
            border-radius: 15px;
            padding: 60px 30px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.05);
        }

        .hero-title {
            font-size: 2.8rem;
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
        
    </style>
</head>
<body>
    <?php include 'include/nav.php'; ?>
    <?php include 'include/condb.php'; ?>

    <div class="container py-4">
        <h3 class="text-center mb-4">Welcome to <strong>AliMama</strong></h3>

        <div class="row align-items-center" id="hero">
            <div class="col-lg-6">
                <h1 class="hero-title">AliMama — Your One-Stop Online Shopping Destination!</h1>
                <p class="hero-text">
                    Discover a wide range of quality products at unbeatable prices.
                    Whether you're looking for the latest in fashion, electronics, home essentials, or gifts —
                    we've got you covered. Enjoy fast delivery, secure payments,
                    and outstanding customer service.
                </p>
                <a href="login.php" class="btn btn-dark mt-3">
                    Start Shopping <i class="fas fa-cart-shopping ms-2"></i>
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
