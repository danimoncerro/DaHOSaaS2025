<?php
session_start();

if (!isset($_SESSION['pending_verification'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codeEntered = trim($_POST['code'] ?? '');
    $correctCode = $_SESSION['pending_verification']['code'] ?? '';

    if ($codeEntered === $correctCode) {
        $_SESSION['customer_id'] = $_SESSION['pending_verification']['customer_id'];
        $_SESSION['store_name'] = $_SESSION['pending_verification']['store_name'];

        // Ștergem verificarea temporară
        unset($_SESSION['pending_verification']);

        // Redirecționare către magazinul public
        $store = $_SESSION['store_name'];
        header("Location: ../stores/online_stores/$store/$store.php");
        exit();
    } else {
        $error = "Codul introdus este greșit. Te rugăm să verifici emailul.";
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Confirmare cod</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3 class="mb-4">🔐 Confirmă codul primit pe email</h3>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="form-group">
            <label>Cod de confirmare:</label>
            <input type="text" name="code" class="form-control" required autofocus>
        </div>
        <button type="submit" class="btn btn-primary">Confirmă codul</button>
    </form>
</div>
</body>
</html>
