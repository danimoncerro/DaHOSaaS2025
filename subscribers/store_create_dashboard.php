<?php
echo "Test1 <br>";

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $storeName = $_POST['storeName'];
    $template = $_POST['template'];
    $firstName = $_SESSION['first_name'];
    echo "Test2 <br>";
  
    // Crearea dashboard-ului noului magazin
    $dashboardContent = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - {$storeName}</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <header class="bg-primary text-white text-center py-5">
        <h1>Dashboard-ul magazinului {$storeName} a lui {$firstName}</h1>
        <a href="../logout.php" class="btn btn-light">Logout</a>
    </header>
    <main class="container my-5">
        <p>Bine ai venit în dashboard-ul magazinului tău!</p>
        <form action="../stores/process_create_store.php" method="post">
            <input type="hidden" name="store_name" value="{$storeName}">
            <input type="hidden" name="template" value="{$template}">
            <button type="submit" class="btn btn-success">Creează magazinul</button>
        </form>
        <!-- Adaugă conținut specific pentru dashboard-ul magazinului aici -->
    </main>
    <footer class="text-center py-3">
        <p>&copy; 2025 My SaaS App. All rights reserved.</p>
    </footer>
</body>
</html>
HTML;

    file_put_contents("../stores/{$storeName}_dashboard.php", $dashboardContent);

    // Redirecționează către dashboard-ul noului magazin
    header("Location: ../stores/{$storeName}_dashboard.php");
    exit();
}
?>
