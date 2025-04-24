<?php
spl_autoload_register(function ($class) {
    $baseDir = __DIR__ . '/';

    // Tratăm namespace-ul App\Core separat
    if (str_starts_with($class, 'App\\Core\\')) {
        $file = $baseDir . 'core/' . str_replace('App\\Core\\', '', $class) . '.php';
    } else {
        // Restul claselor merg în app/
        $file = $baseDir . str_replace('App\\', 'app/', str_replace('\\', '/', $class)) . '.php';
    }

    if (file_exists($file)) {
        require_once $file;
    } else {
        echo "<b>❌ Fișierul pentru clasa $class nu a fost găsit la: $file</b>";
        exit;
    }
});
