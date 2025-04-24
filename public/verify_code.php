<?php
session_start();
if (!isset($_SESSION['2fa_code']) || !isset($_SESSION['2fa_email'])) {
    die("Acces nepermis.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredCode = trim($_POST['code']);
    if ($enteredCode == $_SESSION['2fa_code']) {
        $_SESSION['customer_id'] = $_SESSION['2fa_customer_id'];
        $_SESSION['customer_email'] = $_SESSION['2fa_email'];
        $storeName = $_SESSION['2fa_store_name'];

        // Curățăm datele 2FA
        unset($_SESSION['2fa_code']);
        unset($_SESSION['2fa_customer_id']);
        unset($_SESSION['2fa_store_name']);
        unset($_SESSION['2fa_email']);

        header("Location: customer_dashboard.php?store=" . urlencode($storeName));
        exit();
    } else {
        $error = "Cod incorect. Încearcă din nou.";
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Verificare cod</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card mx-auto" style="max-width: 400px;">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Verificare cod</h4>
        </div>
        <div class="card-body">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <label for="code">Cod primit pe email</label>
                    <input type="text" name="code" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Verifică</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>