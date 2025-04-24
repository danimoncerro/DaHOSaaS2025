<?php 
session_start();

require_once '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $storeName = $_POST['storeName'];
    $template = $_POST['template'];
    $firstName = $_SESSION['first_name'];

    // Creează folderul magazinului
    $storeFolder = "../stores/online_stores/$storeName";
    if (!is_dir($storeFolder)) {
        mkdir($storeFolder, 0755, true);
    }

    // Crearea dashboard-ului noului magazin
    $dashboardContent = <<<HTML

<?php
session_start();

if (!isset(\$_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

\$storeName = "$storeName";
\$firstName = "$firstName";
\$template = "$template";
\$storeFile = "../stores/online_stores/$storeName/{$storeName}.php"; // Calea către fișierul magazinului

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?php echo htmlspecialchars(\$storeName); ?></title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <header class="bg-primary text-white text-center py-5">
        <h1>Dashboard-ul magazinului <?php echo htmlspecialchars(\$storeName); ?> a lui <?php echo htmlspecialchars(\$firstName); ?></h1>
        <a href="../public/logout.php" class="btn btn-light">Logout</a>
    </header>
    <main class="container my-5">
        <p>Bine ai venit în dashboard-ul magazinului tău!</p>

HTML;
    $storeFile = "../stores/online_stores/$storeName/{$storeName}.php";
   
    // **✅ Adaugă verificare pentru a NU afișa formularul dacă magazinul există**
    $dashboardContent .= <<<HTML
        <?php if (!file_exists(\$storeFile)) { ?>
            <form action="../../../subscribers/process_create_store.php" method="post">
                <input type="hidden" name="store_name" value="<?php echo htmlspecialchars(\$storeName); ?>">
                <input type="hidden" name="template" value="<?php echo htmlspecialchars(\$template); ?>">
                <button type="submit" class="btn btn-success">Crează magazinul</button>
            </form>

            
        <?php } ?>
HTML;

    $dashboardContent .= <<<HTML
    </main>
    <footer class="text-center py-3">
        <p>&copy; 2025 My SaaS App. All rights reserved.</p>
    </footer>
</body>
</html>
HTML;

    file_put_contents("../stores/online_stores/$storeName/{$storeName}_dashboard.php", $dashboardContent);

    // Redirecționează către dashboard-ul noului magazin
    header("Location: ../stores/online_stores/$storeName/{$storeName}_dashboard.php");
    exit();
}
?>
