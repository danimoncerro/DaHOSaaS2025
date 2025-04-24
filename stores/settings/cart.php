<?php
session_start();
require_once "../../config/config.php";

$cart = $_SESSION['cart'] ?? [];

$produse = [];
$totalGeneral = 0.0;

$conn = connectDB();

if (!empty($cart)) {
    foreach ($cart as $item) {
        $productId = $item['product_id'];
        $stmt = $conn->prepare("SELECT * FROM produse WHERE id_produs = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $row['quantity'] = $item['quantity'];
            $row['total'] = $row['pret'] * $item['quantity'];
            $row['store_id'] = $item['store_id'];
            $produse[] = $row;
            $totalGeneral += $row['total'];
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Coșul meu</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { background-color: #f0fdfb; font-family: 'Segoe UI', Tahoma, sans-serif; }
        header { background-color: #28a745; color: white; padding: 20px; text-align: center; }
        .product-img { height: 60px; }
        footer { background-color: #222; color: white; text-align: center; padding: 20px; margin-top: 50px; }
    </style>
</head>
<body>

<header>
    <h1>🛒 Coșul de cumpărături</h1>
</header>

<main class="container my-5">
    <?php if (empty($produse)): ?>
        <div class="alert alert-info text-center">
            Coșul tău este gol.
        </div>
    <?php else: ?>
        <form method="POST" action="update_cart.php">
            <table class="table table-bordered table-hover bg-white">
                <thead class="thead-light">
                    <tr>
                        <th>Imagine</th>
                        <th>Produs</th>
                        <th>Preț</th>
                        <th>Cantitate</th>
                        <th>Total</th>
                        <th>Acțiune</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produse as $produs): ?>
                    <tr>
                        <td>
                            <?php if (!empty($produs['pic'])): ?>
                                <img src="/my-saas-app/public/images/<?= htmlspecialchars($produs['pic']) ?>" class="product-img">
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($produs['denumire']) ?></td>
                        <td><?= number_format($produs['pret'], 2) ?> lei</td>
                        <td>
                            <input type="number" name="quantities[<?= $produs['id_produs'] ?>]" value="<?= $produs['quantity'] ?>" min="1" class="form-control" style="width: 80px;">
                        </td>
                        <td><?= number_format($produs['total'], 2) ?> lei</td>
                        <td>
                            <form method="POST" action="remove_from_cart.php" onsubmit="return confirm('Ștergi produsul din coș?')">
                                <input type="hidden" name="product_id" value="<?= $produs['id_produs'] ?>">
                                <input type="hidden" name="store_id" value="<?= $produs['store_id'] ?>">
                                <button class="btn btn-danger btn-sm">Șterge</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-right">Total general:</th>
                        <th colspan="2"><?= number_format($totalGeneral, 2) ?> lei</th>
                    </tr>
                </tfoot>
            </table>
            <div class="text-center">
                <button type="submit" class="btn btn-warning btn-lg mr-2">Actualizează cantitățile</button>
                <a href="checkout.php" class="btn btn-success btn-lg mr-2">Finalizează comanda</a>
                <a href="javascript:history.back()" class="btn btn-secondary btn-lg">Continuă cumpărăturile</a>
            </div>
        </form>
    <?php endif; ?>
</main>

<footer>
    &copy; <?= date('Y') ?> DaHo Tech Solutions. Toate drepturile rezervate.
</footer>

</body>
</html>
