<?php
session_start();

if (!isset($_POST['product_id'], $_POST['store_id'])) {
    die("Date invalide pentru ștergerea produsului.");
}

$productId = (int) $_POST['product_id'];
$storeId = (int) $_POST['store_id'];
$cartKey = $storeId . '-' . $productId;

if (isset($_SESSION['cart'][$cartKey])) {
    unset($_SESSION['cart'][$cartKey]);
}

header("Location: cart.php");
exit;
?>
