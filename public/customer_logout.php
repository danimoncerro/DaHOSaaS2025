<?php
session_start();
session_unset();
session_destroy();

// Obține numele magazinului din parametru și redirecționează înapoi în magazin
$storeName = $_GET['store_name'] ?? '';
if ($storeName) {
    header("Location: /my-saas-app/stores/online_stores/$storeName/$storeName.php");
    exit;
} else {
    echo "Eroare: Numele magazinului nu a fost specificat.";
}
?>