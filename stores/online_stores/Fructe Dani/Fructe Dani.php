<?php
session_start();
require_once __DIR__ . '/../../../config/config.php';

// Obține numele fișierului pentru a identifica magazinul
$currentFile = basename(__FILE__);
preg_match('/^(.*?)\.php$/', $currentFile, $matches);
$storeName = $matches[1] ?? 'Magazin';

$conn = connectDB();
$stmt = $conn->prepare("SELECT id FROM stores WHERE store_name = ?");
$stmt->bind_param("s", $storeName);
$stmt->execute();
$result = $stmt->get_result();
$store = $result->fetch_assoc();
$storeId = $store['id'] ?? 0;
$stmt->close();

// Preluăm stiluri personalizate
$settings = [
    'header_color' => '#a8e063',
    'background_color' => '#f8fff2',
    'title' => $storeName,
    'slogan' => 'Fructe, legume și sucuri naturale - direct de la fermieri'
];

if ($storeId) {
    $stmt = $conn->prepare("SELECT * FROM store_settings WHERE store_id = ?");
    $stmt->bind_param("i", $storeId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $settings = array_merge($settings, $row);
    }
    $stmt->close();
}

$produse = [];
if ($storeId) {
    $stmt = $conn->prepare("SELECT * FROM produse WHERE store_id = ? ORDER BY id_produs DESC");
    $stmt->bind_param("i", $storeId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $produse[] = $row;
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($settings['title']) ?> | Fructe & Legume Proaspete</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: <?= htmlspecialchars($settings['background_color']) ?>;
            font-family: 'Segoe UI', sans-serif;
        }
        header {
            background-color: <?= htmlspecialchars($settings['header_color']) ?>;
            color: #fff;
            padding: 30px 20px;
            position: relative;
            text-align: center;
        }
        .auth-buttons {
            position: absolute;
            top: 20px;
            right: 30px;
        }
        .auth-buttons a {
            margin-left: 10px;
        }
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .product-card {
            border: 1px solid #cde6c7;
            border-radius: 12px;
            background: #fff;
            padding: 15px;
            text-align: center;
            transition: transform 0.2s;
        }
        .product-card:hover {
            transform: scale(1.02);
        }
        .product-card img {
            max-height: 150px;
            object-fit: contain;
            margin-bottom: 10px;
        }
        footer {
            margin-top: 50px;
            background: #e0ffe0;
            color: #444;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

<header>
    <h1><?= htmlspecialchars($settings['title']) ?></h1>
    <p style="font-size: 1.2rem;"><?= htmlspecialchars($settings['slogan']) ?></p>
    <div class="auth-buttons">
        <?php if (!isset($_SESSION['customer_id'])): ?>
            <a href="/my-saas-app/public/customer_form_register.php?store_name=<?= $storeName ?>" class="btn btn-outline-light btn-sm">Înregistrare</a>
            <a href="/my-saas-app/public/customer_form_login.php?store_name=<?= $storeName ?>" class="btn btn-light btn-sm">Autentificare</a>
        <?php else: ?>
            <a href="/my-saas-app/public/customer_dashboard.php?store=<?= urlencode($storeName) ?>" class="btn btn-outline-light btn-sm">Administrare comenzi</a>
            <a href="/my-saas-app/secure/customer_logout.php" class="btn btn-light btn-sm">Logout</a>
        <?php endif; ?>
    </div>
</header>

<main class="container">
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <div class="alert alert-success text-center mt-4" role="alert">
            ✅ Comanda ta a fost trimisă cu succes! Îți mulțumim pentru încredere! 🧺🍎
        </div>
    <?php endif; ?>

    <div class="text-center my-4">
        <a href="/my-saas-app/stores/settings/cart.php" class="btn btn-warning mr-2">Vizualizează coșul</a>
        <a href="/my-saas-app/stores/settings/checkout.php" class="btn btn-success">Finalizează comanda</a>
    </div>

    <section>
        <h3 class="text-success">Produse disponibile</h3>
        <?php if (count($produse) > 0): ?>
        <div class="product-grid">
            <?php foreach ($produse as $produs): ?>
            <div class="product-card">
                <?php if (!empty($produs['pic'])): ?>
                    <img src="/my-saas-app/public/images/<?= htmlspecialchars($produs['pic']) ?>" alt="<?= htmlspecialchars($produs['denumire']) ?>">
                <?php endif; ?>
                <h5><?= htmlspecialchars($produs['denumire']) ?></h5>
                <p><?= htmlspecialchars($produs['descriere']) ?></p>
                <p><strong><?= htmlspecialchars($produs['pret']) ?> lei</strong> / <?= htmlspecialchars($produs['UM']) ?></p>
                <form action="/my-saas-app/stores/settings/add_to_cart.php" method="POST" class="mt-2">
                    <input type="hidden" name="product_id" value="<?= $produs['id_produs'] ?>">
                    <input type="hidden" name="store_id" value="<?= $storeId ?>">
                    <div class="form-group">
                        <input type="number" name="quantity" class="form-control d-inline-block" value="1" min="1" max="999" style="width: 70px;" required>
                        <button type="submit" class="btn btn-success btn-sm">Adaugă în coș</button>
                    </div>
                </form>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
            <p class="text-muted">Nu există produse momentan.</p>
        <?php endif; ?>
    </section>
</main>

<footer>
    <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($settings['title']) ?> • Fructe și legume proaspete</p>
</footer>
</body>
</html>
