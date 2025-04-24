<?php
require_once '../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifică dacă toate datele necesare sunt transmise
    if (!isset($_POST['id_produs'], $_POST['store_id'], $_POST['denumire'], $_POST['pret'], $_POST['UM'], $_POST['stoc'], $_POST['stoc_limitat'])) {
        die("Date lipsă pentru actualizare.");
    }

    $id_produs = intval($_POST['id_produs']);
    $store_id = intval($_POST['store_id']);
    $nume = $_POST['denumire'];
    $pret = floatval($_POST['pret']);
    $unitate = $_POST['UM'];
    $stoc = intval($_POST['stoc']);
    $limita_stoc = intval($_POST['stoc_limitat']);
    $descriere = $_POST['descriere'] ?? '';
    $imagine = '';

    // Dacă se trimite o imagine nouă, o salvăm
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = '../../public/images/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        $uploadPath = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
            $imagine = $filename;
        }
    }

    // Conectare la baza de date și actualizare
    $conn = connectDB();
    if ($imagine !== '') {
        $stmt = $conn->prepare("UPDATE produse SET denumire = ?, pret = ?, UM = ?, stoc = ?, stoc_limitat = ?, descriere = ?, pic = ? WHERE id_produs = ? AND store_id = ?");
        $stmt->bind_param("sdsiissii", $nume, $pret, $unitate, $stoc, $limita_stoc, $descriere, $imagine, $id_produs, $store_id);
    } else {
        $stmt = $conn->prepare("UPDATE produse SET denumire = ?, pret = ?, UM = ?, stoc = ?, stoc_limitat = ?, descriere = ? WHERE id_produs = ? AND store_id = ?");
        $stmt->bind_param("sdsiisii", $nume, $pret, $unitate, $stoc, $limita_stoc, $descriere, $id_produs, $store_id);
    }

    $stmt->execute();
    $stmt->close();
    $conn->close();

    // Redirecționează înapoi către dashboard cu mesaj de succes
    $storeName = $_POST['store_name'] ?? 'magazin';
    header("Location: /my-saas-app/stores/online_stores/{$storeName}/{$storeName}_admin_dashboard.php?section=produse&added=1");
    exit;
} else {
    echo "Acces interzis.";
}
