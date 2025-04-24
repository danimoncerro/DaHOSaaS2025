<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../public/login.php");
    exit;
}

$user = $_SESSION['user'];

$pdo = new PDO("mysql:host=localhost;dbname=my_saas_app;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $pdo->prepare("SELECT store_name FROM stores WHERE user_id = :user_id");
$stmt->execute(['user_id' => $user['user_id']]);
$stores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Abonat - DaHo Tech Solutions</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0fdfb;
            font-family: 'Segoe UI', Tahoma, sans-serif;
        }
        header {
            background-color: #17a2b8;
            color: white;
            padding: 20px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .logo {
            height: 60px;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .store-list a {
            font-weight: bold;
            color: #17a2b8;
            text-decoration: none;
        }
        .store-list a:hover {
            text-decoration: underline;
        }
        footer {
            background-color: #222;
            color: white;
            padding: 20px;
            margin-top: 40px;
            text-align: center;
        }
    </style>
</head>
<body>

<header>
    <div class="d-flex align-items-center">
        <img src="../public/images/logo.png" alt="DaHo Logo" class="logo mr-3">
        <h2 class="m-0">Dashboard abonat</h2>
    </div>
    <a href="../public/logout.php" class="btn btn-light">Logout</a>
</header>

<main class="container text-center my-5">
    <h3>Bine ai venit, <?= htmlspecialchars($user['first_name']) ?>!</h3>
    <p>Ai acces la toate funcționalitățile platformei DaHo Tech Solutions.</p>

    <a href="select_store_templates.php" class="btn btn-success my-4">Crează un magazin nou</a>

    <h4 class="mb-3">Magazinele tale</h4>

    <?php if (count($stores) > 0): ?>
        <ul class="list-group store-list">
            <?php foreach ($stores as $store): ?>
                <li class="list-group-item">
                    <a href="../stores/online_stores/<?= htmlspecialchars($store['store_name']) ?>/<?= htmlspecialchars($store['store_name']) ?>_admin_dashboard.php">
                        <?= htmlspecialchars($store['store_name']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="text-muted">Nu ai niciun magazin creat încă.</p>
    <?php endif; ?>
</main>

<footer>
    &copy; 2025 DaHo Tech Solutions. Toate drepturile rezervate.
</footer>

</body>
</html>
