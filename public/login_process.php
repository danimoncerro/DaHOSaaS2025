<?php
session_start();
require_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $conn = connectDB();

    $stmt = $conn->prepare("SELECT id, first_name, last_name, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $first_name, $last_name, $hashed_password, $role);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Autentificare reușită
            $_SESSION['user_id'] = $id;
            $_SESSION['first_name'] = $first_name;
            $_SESSION['last_name'] = $last_name;
            $_SESSION['user_role'] = $role;

            // Cheie standardizată folosită în toate verificările de sesiune
            $_SESSION['user'] = [
                'user_id' => $id,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'user_role' => $role
            ];

            header("Location: ../subscribers/subscr_dashboard.php");
            exit();
        } else {
            // Parola incorectă
            header("Location: login.php?error=invalid_credentials");
            exit();
        }
    } else {
        // Email inexistent
        header("Location: login.php?error=invalid_credentials");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: login.php");
    exit();
}
