<?php
// stores/settings/process_add_product.php
//require_once(__DIR__ . '/../../../config/config.php');

$testPath = __DIR__ . '/../../config/config.php';
echo 'Verificăm calea: ' . $testPath . '<br>';
echo file_exists($testPath) ? '✅ OK' : '❌ Nu există';
require_once(dirname(__DIR__, 2) . '/config/config.php');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $storeId = $_POST['store_id'] ?? null;
    $denumire = $_POST['denumire'] ?? '';
    $pret = $_POST['pret'] ?? '';
    $um = $_POST['UM'] ?? '';
    $stoc = $_POST['stoc'] ?? 0;
    $stoc_limitat = $_POST['stoc_limitat'] ?? 0;
    $descriere = $_POST['descriere'] ?? '';
    $picName = '';

    // Salvare imagine (dacă există)
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../public/images/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Creează folderul dacă nu există
        }
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $picName = uniqid() . '.' . $extension;
        $destination = $uploadDir . $picName;
        move_uploaded_file($_FILES['image']['tmp_name'], $destination);
    }

    $conn = connectDB();
    $stmt = $conn->prepare("INSERT INTO produse (store_id, denumire, pret, UM, stoc, stoc_limitat, descriere, pic) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssiiss", $storeId, $denumire, $pret, $um, $stoc, $stoc_limitat, $descriere, $picName);
    $stmt->execute();
    $stmt->close();

    // Luăm numele magazinului pentru redirect
    $storeStmt = $conn->prepare("SELECT store_name FROM stores WHERE id = ?");
    $storeStmt->bind_param("i", $storeId);
    $storeStmt->execute();
    $result = $storeStmt->get_result();
    $store = $result->fetch_assoc();
    $storeName = $store['store_name'] ?? '';
    $storeStmt->close();

    $conn->close();

    if ($storeName) {
        header("Location: /my-saas-app/stores/online_stores/{$storeName}/{$storeName}_admin_dashboard.php?section=produse&added=1");
        exit;
    } else {
        echo "Eroare: Nu s-a putut identifica magazinul.";
    }
} else {
    echo "Acces interzis.";
}
