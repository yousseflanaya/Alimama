<?php
session_start();
require_once 'include/condb.php';

if (isset($_POST['connexion'])) {
    $login = trim($_POST['user']);
    $password = trim($_POST['password']);

    if (!empty($login) && !empty($password)) {
        $sqlState = $pdo->prepare("SELECT * FROM utilisateur WHERE login = ? AND password = ?");
        $sqlState->execute([$login, $password]);
        $user = $sqlState->fetch();

        if ($user) {
            $_SESSION['utilisateur'] = $user;
            header('Location: admin.php');
            exit;
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <title>Login | AliMama</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            background: #f8f9fa;
        }
        .login-card {
            max-width: 400px;
            margin: 60px auto;
            padding: 2rem;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.05);
        }
        .login-card h4 {
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
    <div class="login-card">
        <h4 class="text-center">Log in to AliMama</h4>

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

            <button type="submit" name="connexion" class="btn btn-success">Log In</button>
        </form>

        <hr class="my-4" />

        <div class="text-center">
            <p class="mb-2">Don't have an account?</p>
            <a href="createacc.php" class="btn btn-primary">Create Account</a>
        </div>
    </div>
</div>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
