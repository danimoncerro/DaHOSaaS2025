<?php
// View pentru pagina Taraba Hortigrup
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Taraba Hortigrup</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; }
        .product-card { box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden; margin: 15px 0; }
        .product-card img { width: 100%; height: auto; }
        .product-info { padding: 15px; }
        .product-title { font-weight: bold; color: #007bff; }
        .form-control, .btn { border-radius: 0.5rem; }
        footer { background-color: #28a745; color: white; text-align: center; padding: 15px 0; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="text-center mb-4">
            <img src="/my-saas-app/public/images/HG_logo.png" alt="Logo Hortigrup" style="max-width: 300px;">
            <h1 class="mt-3">Taraba Hortigrup</h1>
            <p class="lead">Hortigrup - cultivat responsabil</p>
            <div class="alert alert-info mt-3">
                Livrăm în fiecare marți și vineri între orele 16:30 - 19 în Baia Mare și împrejurimi.<br>
                Comenzile plasate în ziua de livrare după ora 16 se livrează în următoarea serie.
            </div>
        </div>

        <h2 class="text-center text-primary mb-4">Formular de comandă</h2>
        <div class="row">
        <?php foreach ($produse as $produs): ?>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <img src="/my-saas-app/public/images/<?= $produs['pic'] ?>" class="card-img-top" alt="<?= $produs['denumire'] ?>">
                    <div class="card-body">
                            <h5 class="card-title text-center text-primary"><?= htmlspecialchars($produs['denumire']) ?></h5>
                            <div class="d-flex justify-content-center align-items-center flex-wrap mb-2" style="gap: 5px;">
                                <span><?= htmlspecialchars($produs['pret']) ?> lei x</span>
                                <input type="number" name="cantitate[<?= $produs['id_produs'] ?>]" min="0"  style="width: 60px; text-align: center;">
                                <span><?= htmlspecialchars($produs['UM']) ?></span>
                                <span>🛒</span>
                            </div>
                            <?php if (strtolower($produs['stoc']) === 'limitat'): ?>
                                <span class="badge badge-warning">stoc limitat</span>
                            <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>

    <hr>

<h2 style="text-align: center; margin-top: 40px;">Formular de comandă</h2>
<form action="#" method="post" style="max-width: 600px; margin: 30px auto;">
    <div class="form-group">
        <label for="nume">Nume:</label>
        <input type="text" id="nume" name="nume" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="telefon">Telefon:</label>
        <input type="text" id="telefon" name="telefon" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" class="form-control">
    </div>

    <div class="form-group">
        <label for="adresa">Adresa:</label>
        <input type="text" id="adresa" name="adresa" class="form-control">
    </div>

    <div class="form-group">
        <label for="localitate">Localitate:</label>
        <input type="text" id="localitate" name="localitate" class="form-control">
    </div>

    <div class="form-group">
        <label for="observatii">Observații:</label>
        <textarea id="observatii" name="observatii" class="form-control" rows="3"></textarea>
    </div>

    <button type="submit" class="btn btn-primary btn-block mt-3">Trimite comanda</button>
</form>



    <footer>
        &copy;<?= date('Y') ?> Taraba Hortigrup Fruco
    </footer>
</body>
</html>
