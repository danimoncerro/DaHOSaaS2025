<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$storeName = isset($_GET['storeName']) ? $_GET['storeName'] : 'Magazin';
$template = isset($_GET['template']) ? $_GET['template'] : 'template';
$firstName = isset($_GET['firstName']) ? $_GET['firstName'] : 'Utilizator';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?php echo htmlspecialchars($storeName); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header class="bg-primary text-white text-center py-5">
        <h1>Dashboard-ul magazinului <?php echo htmlspecialchars($storeName); ?> a lui <?php echo htmlspecialchars($firstName); ?></h1>
        <a href="logout.php" class="btn btn-light">Logout</a>
    </header>
    <main class="container my-5">
        <p>Bine ai venit în dashboard-ul magazinului tău!</p>
        <!-- Adaugă conținut specific pentru dashboard-ul magazinului aici -->
    </main>
    <footer class="text-center py-3">
        <p>&copy; 2025 My SaaS App. All rights reserved.</p>
    </footer>
</body>
</html>