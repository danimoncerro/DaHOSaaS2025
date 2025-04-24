<?php
require_once '../../config/config.php';

if (!isset($_POST['store_name']) || empty($_POST['store_name'])) {
    die("Numele magazinului lipsește din parametrii.");
}

$storeName = $_POST['store_name'];
$conn = connectDB();

// Verificăm dacă magazinul există în baza de date
$stmt = $conn->prepare("SELECT id FROM stores WHERE store_name = ?");
$stmt->bind_param("s", $storeName);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Magazinul specificat nu a fost găsit în baza de date.");
}

$store = $result->fetch_assoc();
$storeId = $store['id'];
$stmt->close();

// === Logica actualizării dashboardului ===
$templateFile = __DIR__ . "/template_admin_dashboard.php";
$destinationFile = __DIR__ . "/../online_stores/$storeName/{$storeName}_admin_dashboard.php";

if (!file_exists($templateFile)) {
    die("⚠️ Template-ul dashboard-ului nu a fost găsit.");
}

if (!file_exists(dirname($destinationFile))) {
    die("⚠️ Folderul magazinului nu există.");
}

if (!copy($templateFile, $destinationFile)) {
    die("❌ Eroare la copierea fișierului dashboard.");
}

// Redirecționare cu mesaj de succes
header("Location: ../online_stores/{$storeName}/{$storeName}_admin_dashboard.php?updated=1");
exit();
?>
