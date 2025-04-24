<?php
session_start();
session_unset();
session_destroy();

if (isset($_SERVER['HTTP_REFERER'])) {
    // Extrage din URL numele magazinului (ex: Taraba_verde_8)
    $referer = $_SERVER['HTTP_REFERER'];
    if (preg_match('/online_stores\/([\w-]+)\//', $referer, $matches)) {
        $storeName = $matches[1];
        header("Location: /my-saas-app/stores/online_stores/$storeName/$storeName.php");
        exit;
    }
}

// Dacă nu se poate determina magazinul, redirect la homepage
header("Location: /my-saas-app/");
exit;
?>
