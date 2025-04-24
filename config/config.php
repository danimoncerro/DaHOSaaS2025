<?php
// Definirea constantelor pentru detaliile de conectare la baza de date
define('DB_HOST', 'localhost'); // Adresa serverului de baze de date
define('DB_USER', 'root'); // Numele de utilizator pentru conectarea la baza de date
define('DB_PASS', ''); // Parola pentru conectarea la baza de date
define('DB_NAME', 'my_saas_app'); // Numele bazei de date

// Funcția pentru conectarea la baza de date
function connectDB() {
    // Crearea unei noi conexiuni la baza de date folosind detaliile definite mai sus
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Verificarea dacă conexiunea a reușit
    if ($conn->connect_error) {
        // Dacă conexiunea a eșuat, afișează un mesaj de eroare și oprește execuția scriptului
        die("Connection failed: " . $conn->connect_error);
    }

    // Returnează obiectul de conexiune
    return $conn;
}
?>