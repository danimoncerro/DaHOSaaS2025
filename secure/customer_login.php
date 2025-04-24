<?php


session_start();
require_once '../config/config.php';
require '../vendor/autoload.php'; // Include autoload.php generat de Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Generează un token CSRF dacă nu există deja
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifică token-ul CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid CSRF token");
    }

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $storeName = filter_var($_POST['store_name'], FILTER_SANITIZE_STRING);

    $conn = connectDB();

    $stmt = $conn->prepare("SELECT id, first_name, password, store_name FROM customers WHERE email = ? AND store_name = ?");
    $stmt->bind_param("ss", $email, $storeName);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $first_name, $hashed_password, $store_name);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Generarea codului de verificare
            $verification_code = rand(100000, 999999);
            $_SESSION['verification_code'] = $verification_code;
            $_SESSION['customer_id'] = $id;
            $_SESSION['first_name'] = $first_name;
            $_SESSION['store_name'] = $store_name;
            $_SESSION['email'] = $email;
            $_SESSION['user_role'] = $role;

            // Configurarea PHPMailer pentru a trimite emailul
            $mail = new PHPMailer(true);

            try {
                // Configurări server
                $mail->isSMTP();
                $mail->Host = 'smtp.mail.yahoo.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'dani_moncerro@yahoo.com'; // Înlocuiește cu adresa ta de Yahoo Mail
                $mail->Password = 'xprjpaxspwmyjfif'; // Înlocuiește cu parola ta de aplicație generată
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;

                // Configurări email
                $mail->setFrom('dani_moncerro@yahoo.com', 'Daniel');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Codul de verificare';
                $mail->Body = 'Codul tău de verificare este: ' . $verification_code;

                $mail->send();
                // Redirecționarea către pagina de verificare
                header("Location: ../secure/customer_verify.php");
                exit();
            } catch (Exception $e) {
                echo "Eroare la trimiterea emailului: {$mail->ErrorInfo}";
            }
        } else {
            // Parola este greșită
            header("Location: ../public/customer_form_login.php?store_name={$storeName}&error=invalid_credentials");
            exit();
        }
    } else {
        // Email-ul nu a fost găsit
        header("Location: ../public/customer_form_login.php?store_name={$storeName}&error=invalid_credentials");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>