<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $verification_code = $_POST['verification_code'];

    if ($verification_code == $_SESSION['verification_code']) {
        // Codul de verificare este corect
        unset($_SESSION['verification_code']);

        // Redirecționare către pagina publică a magazinului
        $storeName = $_SESSION['store_name'] ?? '';
        if (!empty($storeName)) {
            header("Location: ../stores/online_stores/{$storeName}/{$storeName}.php");
            exit();
        } else {
            echo "Eroare: Magazinul nu a putut fi identificat.";
            exit();
        }
    } else {
        // Codul de verificare este greșit
        header("Location: ../public/customer_verify.php?error=invalid_code");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Verificare cod</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 400px;">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Introduceți codul de verificare</h5>
            </div>
            <div class="card-body">
                <form action="../secure/customer_verify.php" method="post">
                    <div class="form-group">
                        <label for="verification_code">Cod de verificare:</label>
                        <input type="text" class="form-control" id="verification_code" name="verification_code" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Verifică</button>
                </form>
                <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid_code'): ?>
                    <div class="alert alert-danger mt-3 text-center">
                        Cod incorect. Încearcă din nou.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
