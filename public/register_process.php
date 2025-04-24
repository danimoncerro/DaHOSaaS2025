<?php
require_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $conn = connectDB();

    // Verifică dacă email-ul există deja
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Email-ul există deja, redirecționează cu parametru de eroare
        header("Location: register.php?error=email_exists");
        exit();
    } else {
        // Email-ul nu există, continuă cu înregistrarea
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $first_name, $last_name, $email, $password);

        if ($stmt->execute()) {
            // Redirecționează către pagina de login după înregistrare reușită
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
}
?>