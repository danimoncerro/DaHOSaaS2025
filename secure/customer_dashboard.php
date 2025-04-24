<?php
session_start();

if (!isset($_SESSION['customer_id'])) {
    header("Location: ../public/customer_form_login.php");
    exit();
}

$firstName = $_SESSION['first_name'];
$storeName = $_SESSION['store_name']; // Asigură-te că setezi această variabilă la autentificare

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div style="background-color: #388e3c; color: white; text-align: center; padding: 20px; position: relative;">
        <h1>Salut <?php echo htmlspecialchars($firstName); ?>, bine ai venit în magazinul <?php echo htmlspecialchars($storeName); ?></h1>
        <div style="position: absolute; top: 10px; right: 10px;">
            <a href="../secure/customer_logout.php" class="btn btn-light">Logout</a>
        </div>
    </div>
    <div class="container">
        <h2>Dashboard</h2>
        <p>Bine ai venit în dashboard-ul tău!</p>
        <!-- Adaugă conținut specific pentru dashboard-ul clientului aici -->
    </div>
</body>
</html>