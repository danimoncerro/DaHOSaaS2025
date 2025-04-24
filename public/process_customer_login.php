<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../mailer/trimiteCod.php'; // conține funcția trimiteCod()

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['parola'] ?? '');
    $storeName = trim($_POST['store_name'] ?? '');

    if (empty($email) || empty($password) || empty($storeName)) {
        die("Toate câmpurile sunt obligatorii.");
    }

    $conn = connectDB();
    $stmt = $conn->prepare("SELECT id, password FROM customers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $client = $result->fetch_assoc();
    $stmt->close();

    if ($client && password_verify($password, $client['password'])) {
        $verificationCode = rand(100000, 999999);

        $_SESSION['2fa_customer_id'] = $client['id'];
        $_SESSION['2fa_store_name'] = $storeName;
        $_SESSION['2fa_code'] = $verificationCode;
        $_SESSION['2fa_email'] = $email;

        if (trimiteCod($email, $verificationCode)) {
            header("Location: verify_code.php");
            exit();
        } else {
            echo "Eroare la trimiterea emailului. Verifică configurarea serverului de email.";
        }
    } else {
        echo "Date de autentificare invalide.";
    }

    $conn->close();
} else {
    echo "Acces nepermis.";
}
?>
