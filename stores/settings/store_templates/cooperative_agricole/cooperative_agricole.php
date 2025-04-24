<?php
session_start();
require_once __DIR__ . '/../../../../config/config.php';

// Determinăm numele magazinului din fișier (ex: taraba_hortigrup.php)
$currentFile = basename(__FILE__, ".php");
$storeName = $currentFile;

// Conectare DB și obținere store_id
$conn = connectDB();
$stmt = $conn->prepare("SELECT id FROM stores WHERE store_name = ?");
$stmt->bind_param("s", $storeName);
$stmt->execute();
$result = $stmt->get_result();
$store = $result->fetch_assoc();
$storeId = $store['id'] ?? 0;
$stmt->close();

// Obținem produsele din baza de date pentru acest magazin
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($storeName) ?> | Cooperativă Agricolă</title>
    <link rel="stylesheet" href="/my-saas-app/stores/settings/store_templates/cooperative_agricole/cooperative_agricole.css">
</head>
<body>
    <header>
        <div class="container header-container">
            <div class="logo">Cooperativa <?= htmlspecialchars($storeName) ?></div>
            <div class="nav-buttons">
                <?php if (!isset($_SESSION['customer_id'])): ?>
                    <a href="/my-saas-app/public/customer_form_register.php?store_name=<?= $storeName ?>" class="btn">Înregistrare</a>
                    <a href="/my-saas-app/public/customer_form_login.php?store_name=<?= $storeName ?>" class="btn btn-primary">Autentificare</a>
                <?php else: ?>
                    <a href="/my-saas-app/public/customer_dashboard.php?store=<?= urlencode($storeName) ?>" class="btn">Comenzile mele</a>
                    <a href="/my-saas-app/public/customer_logout.php" class="btn btn-danger">Logout</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="container">
        <h2 class="section-title">Produse disponibile</h2>
        <div class="product-grid">
            <?php foreach ($produse as $produs): ?>
                <div class="product-card">
                    <?php if (!empty($produs['pic'])): ?>
                        <img src="/my-saas-app/public/images/<?= htmlspecialchars($produs['pic']) ?>" alt="<?= htmlspecialchars($produs['denumire']) ?>">
                    <?php endif; ?>
                    <h4><?= htmlspecialchars($produs['denumire']) ?></h4>
                    <p><?= htmlspecialchars($produs['descriere']) ?></p>
                    <p><strong><?= htmlspecialchars($produs['pret']) ?> lei</strong> / <?= htmlspecialchars($produs['UM']) ?></p>
                    <form action="/my-saas-app/stores/settings/add_to_cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?= $produs['id_produs'] ?>">
                        <input type="hidden" name="store_id" value="<?= $storeId ?>">
                        <input type="number" name="quantity" value="1" min="1" max="999" required>
                        <button type="submit">Adaugă în coș</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="cart-actions">
            <a href="/my-saas-app/stores/settings/cart.php" class="btn btn-secondary">🧺 Vizualizează coșul</a>
            <a href="/my-saas-app/stores/settings/checkout.php" class="btn btn-success">✅ Finalizează comanda</a>
        </div>
    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> Cooperativa <?= htmlspecialchars($storeName) ?> - Toate drepturile rezervate</p>
    </footer>
</body>
</html>
