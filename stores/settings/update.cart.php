<?php
session_start();

if (!isset($_POST['quantities']) || !is_array($_POST['quantities'])) {
    header("Location: cart.php");
    exit;
}

foreach ($_POST['quantities'] as $productId => $quantity) {
    $productId = (int)$productId;
    $quantity = (int)$quantity;

    if ($quantity <= 0) {
        continue;
    }

    // Căutăm produsul în coș după cheia compusă storeID-productID
    foreach ($_SESSION['cart'] as $key => &$item) {
        if ($item['product_id'] == $productId) {
            $item['quantity'] = $quantity;
            break;
        }
    }
}

header("Location: cart.php");
exit;
?>
