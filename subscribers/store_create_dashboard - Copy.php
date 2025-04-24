<?php


echo "Test1 <br>";

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Verifică dacă request-ul este POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Inițializare variabile cu verificare
    $storeName = isset($_POST['storeName']) ? $_POST['storeName'] : "Nume Magazin Necunoscut";
    $template = isset($_POST['template']) ? $_POST['template'] : "default";
    $firstName = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : "Utilizator";
    $success = isset($_SESSION['success']) ? $_SESSION['success'] : "";

    echo "Test2 <br>";

    // Crearea conținutului pentru dashboard
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
HTML;

    // Afișare mesaj de succes dacă e setat
    if (!empty($success)) {
        $dashboardContent .= <<<HTML
        <div class="alert alert-success" role="alert">
            Magazinul a fost creat cu succes!
        </div>
HTML;
    }

    // Continuare conținut dashboard
    $dashboardContent .= <<<HTML
        <p>Bine ai venit în dashboard-ul magazinului tău!</p>
        <form action="store_create_dashboard.php" method="post">
            <input type="hidden" name="storeName" value="{$storeName}">
            <input type="hidden" name="template" value="{$template}">
            <button type="submit" class="btn btn-success">Creează magazinul</button>
        </form>
    </main>
    <footer class="text-center py-3">
        <p>&copy; 2025 My SaaS App. All rights reserved.</p>
    </footer>

    <!-- Modal de succes -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Felicitări!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Magazinul a fost creat cu succes!
                </div>
                <div class="modal-footer">
                    <a href="../stores/{$storeName}.php" class="btn btn-primary">Spre magazin</a>
                    <a href="../stores/{$storeName}_dashboard.php" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js


/* echo "Test1 <br>";

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
  
    //die("🚀 create_store.php s-a initiat cu succes!");
    // Crearea dashboard-ului noului magazin

    // Inițializare variabile pentru a preveni erorile "Undefined variable"
    $storeName = isset($storeName) ? $storeName : "Nume Magazin Necunoscut";
    $firstName = isset($firstName) ? $firstName : "Utilizator";
    //$success = isset($success) ? $success : "";
    $success = isset($_SESSION['success']) ? $_SESSION['success'] : "";
    

    var_dump($storeName, $firstName, $success);
   

    // Blocul heredoc
    $dashboardContent = <<<HTML
        <h1>Dashboard-ul magazinului $storeName</h1>
        <p>Bine ai venit, $firstName!</p>
        <p>$success</p>
HTML;





   
    

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
        <a href="../logout.php" class="btn btn-light">Logout</a>
    </header>
    <main class="container my-5">
        <?php if (\$success): ?>
            <div class="alert alert-success" role="alert">
                Magazinul a fost creat cu succes!
            </div>
        <?php endif; ?>
        <p>Bine ai venit în dashboard-ul magazinului tău!</p>
        <form action="store_create_dashboard.php" method="post">
            <input type="hidden" name="storeName" value="<?php echo htmlspecialchars(\$storeName); ?>">
            <input type="hidden" name="template" value="<?php echo htmlspecialchars(\$template); ?>">
            <button type="submit" class="btn btn-success">Creează magazinul</button>
        </form>
        <!-- Adaugă conținut specific pentru dashboard-ul magazinului aici -->
    </main>
    <footer class="text-center py-3">
        <p>&copy; 2025 My SaaS App. All rights reserved.</p>
    </footer>

    <!-- Modal de succes -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Felicitări!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Magazinul a fost creat cu succes!
                </div>
                <div class="modal-footer">
                    <a href="../stores/<?php echo htmlspecialchars(\$storeName); ?>.php" class="btn btn-primary">Spre magazin</a>
                    <a href="../stores/<?php echo htmlspecialchars(\$storeName); ?>_dashboard.php" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function()) {
            <?php if (\$success): ?>
                $('#successModal').modal('show');
            <?php endif; ?>
        };
    </script>
</body>
</html>
HTML;

    file_put_contents("../stores/{$storeName}_dashboard.php", $dashboardContent);

    // Redirecționează către dashboard-ul noului magazin
    header("Location: ../stores/{$storeName}_dashboard.php");
    exit();
}*/
?>


