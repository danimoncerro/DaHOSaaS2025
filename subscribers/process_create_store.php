<?php
session_start();
require_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        die("Eroare: utilizatorul nu este autentificat.");
    }

    $storeName = trim($_POST['store_name']);
    if (empty($storeName)) {
        die("Numele magazinului este obligatoriu.");
    }

    $template = $_POST['template'] ?? 'clasic'; // fallback dacă nu vine nimic
    $userId = $_SESSION['user_id'];

    $conn = connectDB();

    // Verifică dacă magazinul există deja
    $checkStmt = $conn->prepare("SELECT id FROM stores WHERE store_name = ?");
    $checkStmt->bind_param("s", $storeName);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        die("Magazinul există deja.");
    }
    $checkStmt->close();

    // Inserare magazin
    $stmt = $conn->prepare("INSERT INTO stores (store_name, user_id) VALUES (?, ?)");
    $stmt->bind_param("si", $storeName, $userId);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    // Creează folder magazin
    $storeFolder = "../stores/online_stores/$storeName";
    if (!is_dir($storeFolder)) {
        mkdir($storeFolder, 0755, true);
    }

    // Căi comune
    $templateAdmin = '../stores/settings/template_admin_dashboard.php';
    $templateDashboard = '../stores/settings/template_dashboard.php';

    // Alege template public în funcție de selecție
    switch ($template) {
        case 'sneakers':
            $templatePublic = '../stores/settings/template_sneakers.php';
            break;
        case 'fruits_veggies':
            $templatePublic = '../stores/settings/template_fruits_veggies.php';
            break;
        case 'cooperative_agricole':
            $templatePublic = '../stores/settings/store_templates/cooperative_agricole/cooperative_agricole.php';
            break;
        case 'clasic':
        default:
            $templatePublic = '../stores/settings/template_public.php';
            break;
    }

    // Verificăm existența fișierelor
    if (!file_exists($templateAdmin) || !file_exists($templateDashboard) || !file_exists($templatePublic)) {
        die("Fișierele template necesare nu au fost găsite.");
    }

    // Copiere fișiere
    copy($templateAdmin, "$storeFolder/{$storeName}_admin_dashboard.php");
    copy($templateDashboard, "$storeFolder/{$storeName}_dashboard.php");
    copy($templatePublic, "$storeFolder/{$storeName}.php");

    // Redirecționare la dashboard
    header("Location: ../stores/online_stores/$storeName/{$storeName}_admin_dashboard.php?success=1");
    exit;
} else {
    echo "Acces nepermis.";
}
