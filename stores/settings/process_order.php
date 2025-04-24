<?php
session_start();
require_once "../../config/config.php";

if (!isset($_SESSION['customer_id']) || !isset($_SESSION['store_name'])) {
    die("Autentificare necesară.");
}

$customer_id = $_SESSION['customer_id'];
$storeName = $_SESSION['store_name'];
$cart = $_SESSION['cart'] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nume = trim($_POST['nume']);
    $telefon = trim($_POST['telefon']);
    $adresa = trim($_POST['adresa']);
    $shipping_method = trim($_POST['shipping_method']);
    $observatii = trim($_POST['observatii']);
    $total = floatval($_POST['total']);

    if (empty($nume) || empty($telefon) || empty($adresa) || empty($shipping_method) || empty($cart)) {
        die("Toate câmpurile obligatorii trebuie completate.");
    }

    $conn = connectDB();

    // Salvăm comanda
    $stmt = $conn->prepare("INSERT INTO orders (customer_id, order_number, status, created_at, total, subtotal, shipping_cost, shipping_method, payment_method, payment_status)
                            VALUES (?, ?, 'Comandă înregistrată', NOW(), ?, ?, 0.00, ?, 'cash', 0)");
    $order_number = rand(10000, 99999);
    $subtotal = $total; // momentan fără taxe suplimentare

    $stmt->bind_param("iidds", $customer_id, $order_number, $total, $subtotal, $shipping_method);
    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();

    // Salvăm produsele din comandă
    foreach ($cart as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];

        // Preluăm prețul curent al produsului
        $stmt = $conn->prepare("SELECT pret FROM produse WHERE id_produs = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();

        if ($product) {
            $pret = $product['pret'];

            $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $pret);
            $stmt->execute();
            $stmt->close();
        }
    }

    $conn->close();

    // Golește coșul și redirecționează
    unset($_SESSION['cart']);
    header("Location: ../online_stores/$storeName/$storeName.php?success=1");
    exit;
} else {
    echo "Acces nepermis.";
}
