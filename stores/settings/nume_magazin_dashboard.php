<?php
// stores/template_dashboard.php

session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Magazin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { font-family: Arial; margin: 0; padding: 0; background: #f4f4f4; }
        .sidebar { width: 220px; background: #2c3e50; min-height: 100vh; float: left; color: white; }
        .sidebar ul { list-style-type: none; padding: 0; }
        .sidebar li { padding: 15px; }
        .sidebar li a { color: white; text-decoration: none; display: block; }
        .sidebar li:hover { background: #34495e; }
        .content { margin-left: 220px; padding: 20px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <ul>
            <li><a href="#"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="#"><i class="fas fa-box"></i> Produse</a></li>
            <li><a href="#"><i class="fas fa-shopping-cart"></i> Comenzi</a></li>

            <?php if (isset($_SESSION['user']) && $_SESSION['user']['user_role'] === 'admin'): ?>
            <li>
                <a href="/my-saas-app/public/index.php?url=admin/modules">
                    <i class="fas fa-puzzle-piece"></i>
                    <span>Module</span>
                </a>
            </li>
            <?php endif; ?>

            <li><a href="/my-saas-app/public/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>
    <div class="content">
        <h1>Bine ai venit în dashboard-ul magazinului!</h1>
        <p>Aici poți gestiona produsele, comenzile și modulele.</p>
    </div>
</body>
</html>