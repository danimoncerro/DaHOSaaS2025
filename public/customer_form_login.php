<?php
session_start();
$storeName = $_GET['store_name'] ?? '';

// Generează token CSRF dacă nu există
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Login Client - <?= htmlspecialchars($storeName) ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card mx-auto" style="max-width: 400px;">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Autentificare Client</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="../secure/customer_login.php">
                <input type="hidden" name="store_name" value="<?= htmlspecialchars($storeName) ?>">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>

                <div class="form-group">
                    <label for="password">Parolă</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success btn-block">Autentificare</button>
            </form>

            <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid_credentials'): ?>
                <div class="alert alert-danger mt-3 text-center">
                    Datele introduse nu sunt corecte. Încearcă din nou.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
