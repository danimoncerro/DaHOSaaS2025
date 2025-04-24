<?php
require_once "../../config/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $store_id = intval($_POST['store_id']);
    $store_name = basename($_POST['store_name']);
    $title = trim($_POST['title']);
    $slogan = trim($_POST['slogan']);
    $header_color = trim($_POST['header_color']);
    $background_color = trim($_POST['background_color']);

    // Validare culori hex
    if (!preg_match('/^#[a-fA-F0-9]{6}$/', $header_color)) $header_color = '#28a745';
    if (!preg_match('/^#[a-fA-F0-9]{6}$/', $background_color)) $background_color = '#f0fdfb';

    $conn = connectDB();

    // Verifică dacă există deja
    $check = $conn->prepare("SELECT id FROM store_settings WHERE store_id = ?");
    $check->bind_param("i", $store_id);
    $check->execute();
    $result = $check->get_result();
    $exists = $result->fetch_assoc();
    $check->close();

    if ($exists) {
        $stmt = $conn->prepare("UPDATE store_settings SET title = ?, slogan = ?, header_color = ?, background_color = ? WHERE store_id = ?");
        $stmt->bind_param("ssssi", $title, $slogan, $header_color, $background_color, $store_id);
    } else {
        $stmt = $conn->prepare("INSERT INTO store_settings (store_id, title, slogan, header_color, background_color) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $store_id, $title, $slogan, $header_color, $background_color);
    }

    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: ../online_stores/{$store_name}/{$store_name}_admin_dashboard.php?style_updated=1");
    exit;
} else {
    echo "Acces nepermis.";
}
