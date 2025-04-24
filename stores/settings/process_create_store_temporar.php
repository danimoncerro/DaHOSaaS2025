<?php
session_start();
require_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['storeName']) && isset($_SESSION['user']['user_id'])) {
    $storeName = preg_replace('/[^a-zA-Z0-9_-]/', '', $_POST['storeName']); // Sanitize
    $userId = $_SESSION['user']['user_id'];

    // Căi către template-uri
    $templateDashboard = "template_dashboard.php";
    $templateAdminDashboard = "template_admin_dashboard.php";

    // Verifică existența fișierelor template
    if (!file_exists($templateDashboard)) {
        die("Fișierul template_dashboard.php nu a fost găsit.");
    }

    if (!file_exists($templateAdminDashboard)) {
        die("Fișierul template_admin_dashboard.php nu a fost găsit.");
    }

    // Creăm folderul magazinului
    $storeFolder = "/stores/online_stores/{$storeName}";
    if (!is_dir($storeFolder)) {
        mkdir($storeFolder, 0755, true);
    }

    // Căi pentru fișierele care vor fi generate în magazin
    $publicPagePath = "$storeFolder/{$storeName}.php";
    $adminDashboardPath = "$storeFolder/{$storeName}_admin_dashboard.php";

    // Copiază dashboard-ul de admin în folderul magazinului
    if (!copy($templateAdminDashboard, $adminDashboardPath)) {
        die("Eroare la copierea dashboard-ului de admin.");
    }

    // Creează pagina publică pe baza template_dashboard.php
    $pageContent = file_get_contents($templateDashboard);
    $pageContent = str_replace('{{store_name}}', $storeName, $pageContent);
    file_put_contents($publicPagePath, $pageContent);

    // Salvează în baza de date
    $conn = connectDB();
    $stmt = $conn->prepare("INSERT INTO stores (store_name, user_id) VALUES (?, ?)");
    $stmt->bind_param("si", $storeName, $userId);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    // Redirect către dashboard-ul nou
    header("Location: /stores/online_stores/{$storeName}/{$storeName}_admin_dashboard.php?success=1");
    exit();
} else {
    die("Date invalide.");
}
