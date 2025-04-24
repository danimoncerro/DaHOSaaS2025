<?php
// stores/settings/mass_update_stores.php

$settingsDir = __DIR__;
$storesDir = dirname(__DIR__) . '/online_stores';

$templatesToCopy = [
    'template_admin_dashboard.php',
    'template_dashboard.php',
    'template_public.php',
    'process_add_product.php',
    'process_edit_product.php',
    'edit_product.php',
    'update_dashboard.php',
    'delete_product.php',
    'add_product_form.php',
    'dashboard.php',
    'customer_dashboard.php'
];

$magazine = array_filter(scandir($storesDir), function ($folder) use ($storesDir) {
    return $folder !== '.' && $folder !== '..' && is_dir("$storesDir/$folder");
});

foreach ($magazine as $storeName) {
    $storePath = "$storesDir/$storeName";

    foreach ($templatesToCopy as $templateFile) {
        $sourcePath = "$settingsDir/$templateFile";

        if (!file_exists($sourcePath)) {
            echo "⚠️ Fișier lipsă în settings: $templateFile<br>";
            continue;
        }

        if (str_contains($templateFile, 'template_admin_dashboard.php')) {
            $targetPath = "$storePath/{$storeName}_admin_dashboard.php";
        } elseif (str_contains($templateFile, 'template_dashboard.php')) {
            $targetPath = "$storePath/{$storeName}_dashboard.php";
        } elseif (str_contains($templateFile, 'template_public.php')) {
            $targetPath = "$storePath/{$storeName}.php";
        } else {
            $targetPath = "$storePath/$templateFile";
        }

        if (copy($sourcePath, $targetPath)) {
            echo "✅ $templateFile actualizat în $storeName<br>";
        } else {
            echo "❌ Eroare la copierea $templateFile în $storeName<br>";
        }
    }
}

echo "<br>🎉 Actualizarea în masă s-a încheiat!";
