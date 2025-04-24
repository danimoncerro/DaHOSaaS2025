<?php
require_once '../config/config.php';


// Preluăm datele din formularul de înregistrare a clientului

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $storeName = $_POST['store_name']; // Preia numele magazinului din formular

    // Verifică dacă store_name este setat
    if (empty($storeName)) {
        die("Store name is required.");
    }

    // Criptarea parolei
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $conn = connectDB();

    $stmt = $conn->prepare("INSERT INTO customers (email, password, first_name, last_name, store_name) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $email, $hashedPassword, $firstName, $lastName, $storeName);

    if ($stmt->execute()) {
        session_start();
        $_SESSION['customer_id'] = $stmt->insert_id;
        $_SESSION['first_name'] = $firstName;
        $_SESSION['store_name'] = $storeName; // Setează numele magazinului corespunzător
        header("Location: ../secure/customer_dashboard.php");
    } else {
        header("Location: ../public/customer_form_register.php?error=1");
    }

    $stmt->close();
    $conn->close();
}
?>