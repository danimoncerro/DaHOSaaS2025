<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../public/login.php");
    exit;
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Selectează un template</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { background-color: #f4f6f8; padding-top: 30px; }
        .container h1 { margin-bottom: 40px; }
        .card img {
            max-height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center text-primary">Alege un template pentru magazinul tău</h1>
    <div class="row">

        <!-- Template clasic -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <img src="/my-saas-app/public/templates/classic.jpg" class="card-img-top" alt="Clasic">
                <div class="card-body">
                    <h5 class="card-title">Template Clasic</h5>
                    <p class="card-text">Un design simplu și eficient pentru orice tip de magazin online.</p>
                    <form action="process_create_store.php" method="POST">
                        <input type="hidden" name="template" value="clasic">
                        <div class="form-group">
                            <label for="store_name">Nume magazin:</label>
                            <input type="text" name="store_name" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mt-2">Folosește acest template</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Template Sneakers -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <img src="/my-saas-app/public/templates/sneakers.jpg" class="card-img-top" alt="Sneakers">
                <div class="card-body">
                    <h5 class="card-title">Sneakers</h5>
                    <p class="card-text">Un template modern pentru magazine de pantofi sport și streetwear.</p>
                    <form action="process_create_store.php" method="POST">
                        <input type="hidden" name="template" value="sneakers">
                        <div class="form-group">
                            <label for="store_name">Nume magazin:</label>
                            <input type="text" name="store_name" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-dark btn-block mt-2">Folosește acest template</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Template Fructe și legume proaspete -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <img src="/my-saas-app/public/templates/fructe_legume_template.jpg" class="card-img-top" alt="Fructe și legume proaspete">
                <div class="card-body">
                    <h5 class="card-title">Fructe și legume proaspete</h5>
                    <p class="card-text">Template ideal pentru magazine de fermieri – aerisit, colorat, cu accent pe prospețime.</p>
                    <form action="process_create_store.php" method="POST">
                        <input type="hidden" name="template" value="fruits_veggies">
                        <div class="form-group">
                            <label for="store_name">Nume magazin:</label>
                            <input type="text" name="store_name" class="form-control" required placeholder="ex: natura-fresh">
                        </div>
                        <button type="submit" class="btn btn-success btn-block mt-2">Folosește acest template</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Template Cooperative agricole -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <img src="/my-saas-app/public/templates/cooperative_agricole.jpg" class="card-img-top" alt="cooperative_agricole">
                <div class="card-body">
                    <h5 class="card-title">Cooperative agricole</h5>
                    <p class="card-text">Template ideal pentru magazine ale cooperativelo agricole – aerisit, colorat, cu accent pe prospețime.</p>
                    <form action="process_create_store.php" method="POST">
                        <input type="hidden" name="template" value="cooperative_agricole">
                        <div class="form-group">
                            <label for="store_name">Nume magazin:</label>
                            <input type="text" name="store_name" class="form-control" required placeholder="ex: natura-fresh">
                        </div>
                        <button type="submit" class="btn btn-success btn-block mt-2">Folosește acest template</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
