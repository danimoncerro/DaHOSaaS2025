<?php
session_start();

if (!isset($_SESSION['customer_id']) || !isset($_SESSION['customer_store'])) {
    header("Location: customer_form_login.php");
    exit;
}

$storeName = $_SESSION['customer_store'];
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Client</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Bun venit, <?= htmlspecialchars($_SESSION['customer_name']) ?>!</h2>
            <a href="/my-saas-app/stores/online_stores/<?= urlencode($storeName) ?>/<?= urlencode($storeName) ?>.php" class="btn btn-primary">Către magazin</a>
        </div>

        <p>Aici poți vedea comenzile tale, statusul livrărilor și alte informații importante.</p>

        <!-- Aici urmează secțiunea pentru afișarea comenzilor -->
    </div>
</body>
</html>
