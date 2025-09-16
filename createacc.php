<?php
session_start();
require_once 'include/condb.php';

if (isset($_POST['ajouter'])) {
    $login = $_POST['user'];
    $password = $_POST['password'];

    if (!empty($login) && !empty($password)) {
        $date = date('Y-m-d');
        $sqlState = $pdo->prepare('INSERT INTO utilisateur (login, password, date_creation) VALUES (?, ?, ?)');
        $success = $sqlState->execute([$login, $password, $date]);

        if ($success) {
            header('Location: login.php');
            exit;
        } else {
            $error = "Error adding user.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | AliMama</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            background: #f8f9fa;
        }
        .account-card {
            max-width: 400px;
            margin: 60px auto;
            padding: 2rem;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.05);
        }
        .account-card h4 {
            font-weight: bold;
            margin-bottom: 1.5rem;
        }
        .btn-success {
            width: 100%;
        }
        .btn-primary {
            width: 100%;
        }
    </style>
</head>
<body>

<?php include 'include/nav.php'; ?>

<div class="container">
    <div class="account-card">
        <h4 class="text-center">Create Your AliMama Account</h4>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger text-center"><?= $error ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" name="user" placeholder="Enter your username" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
            </div>

            <button type="submit" name="ajouter" class="btn btn-success">Create Account</button>
        </form>

        <hr class="my-4" />

        <div class="text-center">
            <p class="mb-2">Already have an account?</p>
            <a href="login.php" class="btn btn-primary">Log In</a>
        </div>
    </div>
</div>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
