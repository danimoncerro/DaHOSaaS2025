<?php
session_start();
require_once __DIR__ . '/../../../config/config.php';

$currentFile = basename(__FILE__);
preg_match('/(.*)\.php/', $currentFile, $matches);
$storeName = $matches[1] ?? 'Magazin';

$conn = connectDB();

// Obținem store_id
$stmt = $conn->prepare("SELECT id FROM stores WHERE store_name = ?");
$stmt->bind_param("s", $storeName);
$stmt->execute();
$result = $stmt->get_result();
$store = $result->fetch_assoc();
$storeId = $store['id'] ?? 0;
$stmt->close();

// Obținem produse
$produse = [];
if ($storeId) {
    $stmt = $conn->prepare("SELECT * FROM produse WHERE store_id = ?");
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
    <title><?= htmlspecialchars($storeName) ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0fdfb;
            font-family: 'Segoe UI', Tahoma, sans-serif;
        }
        header {
            background-color: #28a745;
            color: white;
            padding: 20px;
            position: relative;
        }
        .auth-buttons {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .auth-buttons .btn {
            margin-left: 10px;
        }
        main {
            padding: 40px 20px;
        }
        .product-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            background-color: white;
            text-align: center;
            height: 100%;
        }
        .product-card img {
            max-height: 150px;
            object-fit: contain;
            margin-bottom: 10px;
        }
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }
        .cart-buttons {
            text-align: center;
            margin-bottom: 30px;
        }
        footer {
            background-color: #222;
            color: white;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
<header class="text-center">
    <h1>Bun venit pe pagina magazinului <strong><?= htmlspecialchars($storeName) ?></strong>!</h1>
    <div class="auth-buttons">
        <a href="/my-saas-app/public/customer_form_register.php?store_name=<?= $storeName ?>" class="btn btn-light btn-sm">Înregistrare</a>
        <a href="/my-saas-app/public/customer_form_login.php?store_name=<?= $storeName ?>" class="btn btn-light btn-sm">Autentificare</a>
    </div>
</header>

<main class="container">
    <div class="cart-buttons">
        <a href="/my-saas-app/stores/settings/cart.php" class="btn btn-primary mr-2">Vizualizează coșul</a>
        <a href="/my-saas-app/stores/settings/checkout.php" class="btn btn-success">Finalizează comanda</a>
    </div>

    <section>
        <h3>Produse disponibile</h3>
        <?php if (count($produse) > 0): ?>
            <div class="product-grid mt-4">
                <?php foreach ($produse as $produs): ?>
                    <div class="product-card">
                        <?php if (!empty($produs['pic'])): ?>
                            <img src="/my-saas-app/public/images/<?= htmlspecialchars($produs['pic']) ?>" class="img-fluid" alt="<?= htmlspecialchars($produs['denumire']) ?>">
                        <?php endif; ?>
                        <h5><?= htmlspecialchars($produs['denumire']) ?></h5>
                        <p><?= htmlspecialchars($produs['descriere']) ?></p>
                        <p><strong><?= htmlspecialchars($produs['pret']) ?> lei</strong> / <?= htmlspecialchars($produs['UM']) ?></p>

                        <form action="/my-saas-app/stores/settings/add_to_cart.php" method="POST" class="mt-2">
                            <input type="hidden" name="product_id" value="<?= $produs['id_produs'] ?>">
                            <input type="hidden" name="store_id" value="<?= $storeId ?>">
                            <div class="form-group">
                                <input type="number" name="quantity" class="form-control" value="1" min="1" max="999" style="width: 80px; display: inline-block;" required>
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
    <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($storeName) ?> | DaHo Tech Solutions. Toate drepturile rezervate.</p>
</footer>
</body>
</html>
