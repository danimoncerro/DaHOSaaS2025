<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$storeName = "$storeName";
$firstName = "$firstName";
$template = "$template";
$success = isset($_GET['success']) ? $_GET['success'] : 0;
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
        <?php if ($success): ?>
            <div class="alert alert-success" role="alert">
                Magazinul a fost creat cu succes!
            </div>
        <?php endif; ?>
        <p>Bine ai venit în dashboard-ul magazinului tău!</p>
        <form action="create_store.php" method="post">
            <input type="hidden" name="storeName" value="<?php echo htmlspecialchars($storeName); ?>">
            <input type="hidden" name="template" value="<?php echo htmlspecialchars($template); ?>">
            <button type="submit" class="btn btn-success">Crează magazinul</button>
        </form>
        <!-- Adaugă conținut specific pentru dashboard-ul magazinului aici -->
    </main>
    <footer class="text-center py-3">
        <p>&copy; 2025 My SaaS App. All rights reserved.</p>
    </footer>
</body>
</html>