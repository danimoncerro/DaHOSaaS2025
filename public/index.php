<?php
session_start();

// Autoload și clasele de bază
require_once '../autoload.php';
require_once '../core/Router.php';
require_once '../core/Controller.php';


use Core\Router;

// Inițializăm routerul
$router = new Router();

// Înregistrăm rutele din fișierul dedicat
require_once __DIR__ . '/../routes.php';


// Executăm sistemul de rutare
$router->dispatch();

?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>DaHo Tech Solutions</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background-color: #f0fdfb;
            color: #1a1a1a;
        }
        header {
            background-color: #ffffff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 30px;
        }
        .logo {
            height: 100px;
        }
        .nav-links a {
            margin-left: 20px;
            text-decoration: none;
            color: #2c3e50;
            font-weight: bold;
        }
        .hero {
            text-align: center;
            padding: 100px 20px;
            background: linear-gradient(120deg, #28a745, #17a2b8);
            color: white;
        }
        .hero h1 {
            font-size: 3em;
            margin-bottom: 20px;
        }
        .hero p {
            font-size: 1.2em;
            margin-bottom: 30px;
        }
        .btn-primary {
            background-color: white;
            color: #17a2b8;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            text-decoration: none;
        }
        .section {
            padding: 60px 20px;
            text-align: center;
        }
        .features, .pricing {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
        }
        .card {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            width: 300px;
        }
        footer {
            background-color: #222;
            color: white;
            text-align: center;
            padding: 30px 20px;
        }
        form input, form textarea {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        form button {
            margin-top: 15px;
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<header>
    <img src="images/logo.png" alt="Logo DaHo" class="logo">
    <div class="nav-links">
        <a href="#features">Funcționalități</a>
        <a href="#pricing">Prețuri</a>
        <a href="#contact">Contact</a>
        <a href="register.php">Register</a>
        <a href="login.php">Login</a>
    </div>
</header>

<section class="hero">
    <h1>Soluții inteligente pentru afacerea ta!</h1>
    <p>Transformăm ideile în realitate. Simplu. Rapid. Flexibil.</p>
    <a href="/register" class="btn-primary">Începe acum</a>
</section>

<section class="section" id="features">
    <h2>Ce oferim</h2>
    <div class="features">
        <div class="card">
            <h3>Platformă SaaS completă</h3>
            <p>Gestionare clienți, produse, comenzi și multe altele – totul dintr-un singur loc.</p>
        </div>
        <div class="card">
            <h3>Design Responsive</h3>
            <p>Se adaptează perfect la desktop, tabletă și mobil.</p>
        </div>
        <div class="card">
            <h3>Ușor de personalizat</h3>
            <p>Adaptează magazinul după nevoile brandului tău.</p>
        </div>
    </div>
</section>

<section class="section" id="pricing">
    <h2>Planuri tarifare</h2>
    <div class="pricing">
        <div class="card">
            <h3>Gratuit</h3>
            <p>Ideal pentru testare</p>
            <p><strong>0 RON/lună</strong></p>
        </div>
        <div class="card">
            <h3>Pro</h3>
            <p>Perfect pentru afaceri în creștere</p>
            <p><strong>49 RON/lună</strong></p>
        </div>
        <div class="card">
            <h3>Enterprise</h3>
            <p>Funcționalități avansate și suport dedicat</p>
            <p><strong>99 RON/lună</strong></p>
        </div>
    </div>
</section>

<section class="section" id="contact">
    <h2>Contactează-ne</h2>
    <form method="POST" action="contact_process.php">
        <input type="text" name="name" placeholder="Numele tău" required>
        <input type="email" name="email" placeholder="Emailul tău" required>
        <textarea name="message" placeholder="Mesajul tău" rows="5" required></textarea>
        <button type="submit">Trimite mesaj</button>
    </form>
</section>

<footer>
    &copy; 2025 DaHo Tech Solutions. Toate drepturile rezervate.
</footer>

</body>
</html>
