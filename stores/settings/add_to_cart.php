<?php
session_start();

// Verificăm dacă datele necesare sunt primite
if (!isset($_POST['product_id'], $_POST['quantity'], $_POST['store_id'])) {
    die("Date lipsă pentru adăugarea în coș.");
}

$productId = (int) $_POST['product_id'];
$storeId = (int) $_POST['store_id'];
$quantity = (int) $_POST['quantity'];

if ($quantity <= 0) {
    $quantity = 1;
}

// Inițializăm coșul dacă nu există
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Generăm o cheie unică pentru produsul adăugat în coș (ex: "magazin-12")
$cartKey = $storeId . '-' . $productId;

// Dacă produsul e deja în coș, actualizăm cantitatea
if (isset($_SESSION['cart'][$cartKey])) {
    $_SESSION['cart'][$cartKey]['quantity'] += $quantity;
} else {
    // Salvăm produsul în coș
    $_SESSION['cart'][$cartKey] = [
        'product_id' => $productId,
        'store_id' => $storeId,
        'quantity' => $quantity
    ];
}

// Redirecționăm înapoi la pagina magazinului
// Aici poți înlocui cu adresa dinamică dacă ai URL complet salvat
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
?>
