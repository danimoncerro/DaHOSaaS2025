<?php
$conn = new mysqli("localhost", "root", "", "my_saas_app");

// 1. Obținem store_id pentru taraba1_hortigrup
$store_name = 'taraba1_hortigrup';
$storeQuery = "SELECT id FROM stores WHERE store_name = '$store_name'";
$storeResult = $conn->query($storeQuery);

if ($storeResult && $storeResult->num_rows > 0) {
    $storeRow = $storeResult->fetch_assoc();
    $store_id = $storeRow['id'];

    // 2. Luăm produsele cu acel store_id
    $query = "SELECT * FROM produse WHERE store_id = $store_id";
    $result = $conn->query($query);
    $produse = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
} else {
    $produse = [];
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Taraba Hortigrup</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body style="background-color: #f9f9f9;">
    <div class="text-center mt-4">
        <img src="../public/images/HG_logo.png" alt="Logo" style="height: 80px;">
        <h2>Taraba Hortigrup</h2>
        <p>Hortigrup - cultivat responsabil</p>
    </div>

    <div class="alert alert-info text-center mt-3">
        Livrăm în fiecare marți și vineri între orele 16:30 - 19 în Baia Mare și împrejurimi.<br>
        Comenzile plasate în ziua de livrare după ora 16 se livrează în următoarea serie.
    </div>

    <div class="container mt-5">
        <h3 class="text-primary text-center mb-4">Formular de comandă</h3>

        <div class="row">
        <?php foreach ($produse as $produs): ?>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <img src="/my-saas-app/public/images/<?= $produs['pic'] ?>" class="card-img-top" alt="<?= $produs['denumire'] ?>">
                    <div class="card-body">
                            <h5 class="card-title text-center text-primary"><?= htmlspecialchars($produs['denumire']) ?></h5>
                            <div class="d-flex justify-content-center align-items-center flex-wrap mb-2" style="gap: 5px;">
                                <span><?= htmlspecialchars($produs['pret']) ?> lei x</span>
                                <input type="number" name="cantitate[<?= $produs['id_produs'] ?>]" min="0"  style="width: 60px; text-align: center;">
                                <span><?= htmlspecialchars($produs['UM']) ?></span>
                                <span>🛒</span>
                            </div>
                            <?php if (strtolower($produs['stoc']) === 'limitat'): ?>
                                <span class="badge badge-warning">stoc limitat</span>
                            <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        </div>

        <h4 class="mt-5">Formular de comandă</h4>
        <form>
            <div class="form-group">
                <label for="nume">Nume:</label>
                <input type="text" class="form-control" id="nume" name="nume" required>
            </div>
            <div class="form-group">
                <label for="telefon">Telefon:</label>
                <input type="tel" class="form-control" id="telefon" name="telefon" required>
            </div>
            <div class="form-group">
                <label for="adresa">Adresa:</label>
                <input type="text" class="form-control" id="adresa" name="adresa" required>
            </div>
            <button type="submit" class="btn btn-success">Trimite comanda</button>
        </form>
    </div>
</body>
</html>
