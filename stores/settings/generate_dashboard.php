<?php
// generate_dashboard.php

function create_dashboard_file($storeName)
{
    $templatePath = __DIR__ . '/template_dashboard.php';
    $newDashboardPath = __DIR__ . "/{$storeName}_dashboard.php";

    if (!file_exists($templatePath)) {
        die("Fișierul template_dashboard.php nu a fost găsit.");
    }

    if (copy($templatePath, $newDashboardPath)) {
        echo "Dashboard-ul pentru magazinul {$storeName} a fost creat cu succes: {$storeName}_dashboard.php";
    } else {
        echo "Eroare la copierea fișierului dashboard.";
    }
}

// Exemplu de utilizare
if (isset($_POST['store_name'])) {
    $storeName = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['store_name']); // curățare nume
    create_dashboard_file($storeName);
} else {
    echo "Parametrul ?store=lipsește din URL.";
}
