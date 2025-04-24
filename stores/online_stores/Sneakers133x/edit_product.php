<?php
require_once '../../config/config.php';

$id = $_GET['id'] ?? null;
$storeName = $_GET['store'] ?? null;

if (!$id || !$storeName) {
    die("ID produs lipsă.");
}

$conn = connectDB();

// Obține ID-ul magazinului
$stmt = $conn->prepare("SELECT id FROM stores WHERE store_name = ?");
$stmt->bind_param("s", $storeName);
$stmt->execute();
$result = $stmt->get_result();
$store = $result->fetch_assoc();
$store_id = $store['id'] ?? null;
$stmt->close();

if (!$store_id) {
    die("Magazinul nu a fost găsit.");
}

// Obține detalii produs
$stmt = $conn->prepare("SELECT * FROM produse WHERE id_produs = ? AND store_id = ?");
$stmt->bind_param("ii", $id, $store_id);
$stmt->execute();
$result = $stmt->get_result();
$produs = $result->fetch_assoc();
$stmt->close();
$conn->close();

if (!$produs) {
    die("Produsul nu a fost găsit.");
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Editează Produs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="p-4 bg-light">
<div class="container">
    <h2 class="mb-4">Editează produsul</h2>
    <form action="../settings/process_edit_product.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_produs" value="<?= $produs['id_produs'] ?>">
        <input type="hidden" name="store_id" value="<?= $store_id ?>">
        <input type="hidden" name="store_name" value="<?= $storeName ?>">

        <div class="form-group">
            <label>Nume produs</label>
            <input type="text" name="denumire" class="form-control" value="<?= htmlspecialchars($produs['denumire']) ?>" required>
        </div>

        <div class="form-group">
            <label>Preț</label>
            <input type="text" name="pret" class="form-control" value="<?= htmlspecialchars($produs['pret']) ?>" required>
        </div>

        <div class="form-group">
            <label>Unitate de măsură</label>
            <input type="text" name="UM" class="form-control" value="<?= htmlspecialchars($produs['UM']) ?>">
        </div>

        <div class="form-group">
            <label>Stoc</label>
            <input type="number" name="stoc" class="form-control" value="<?= htmlspecialchars($produs['stoc']) ?>">
        </div>

        <div class="form-group">
            <label>Limită stoc</label>
            <input type="number" name="stoc_limitat" class="form-control" value="<?= htmlspecialchars($produs['stoc_limitat']) ?>">
        </div>

        <div class="form-group">
            <label>Descriere</label>
            <textarea name="descriere" class="form-control" rows="3"><?= htmlspecialchars($produs['descriere']) ?></textarea>
        </div>

        <div class="form-group">
            <label>Imagine produs (opțional)</label>
            <input type="file" name="image" class="form-control-file">
        </div>

        <button type="submit" class="btn btn-primary">Salvează modificările</button>
        <a href="../online_stores/<?= $storeName ?>/<?= $storeName ?>_admin_dashboard.php" class="btn btn-secondary ml-2">Renunță</a>
    </form>
</div>
</body>
</html>
