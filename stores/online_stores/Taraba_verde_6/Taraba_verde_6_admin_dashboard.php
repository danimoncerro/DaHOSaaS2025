<?php
session_start();
require_once __DIR__ . '/../../../config/config.php';

$currentFile = basename(__FILE__);
preg_match('/^(.*?)_admin_dashboard\.php$/', $currentFile, $matches);
$storeName = $matches[1] ?? '';
$storePublicUrl = "/my-saas-app/stores/online_stores/$storeName/$storeName.php";

if (!$storeName) {
    die("<p style='color: red;'>Eroare: Nu a fost identificat magazinul curent.</p>");
}

$conn = connectDB();
$stmt = $conn->prepare("SELECT id FROM stores WHERE store_name = ?");
$stmt->bind_param("s", $storeName);
$stmt->execute();
$result = $stmt->get_result();
$store = $result->fetch_assoc();
$storeId = $store['id'] ?? 0;
$stmt->close();

$settings = [
    'title' => '',
    'slogan' => '',
    'header_color' => '',
    'background_color' => ''
];
$setStmt = $conn->prepare("SELECT * FROM store_settings WHERE store_id = ?");
$setStmt->bind_param("i", $storeId);
$setStmt->execute();
$result = $setStmt->get_result();
if ($row = $result->fetch_assoc()) {
    $settings = $row;
}
$setStmt->close();

$produse = [];
if ($storeId) {
    $stmt = $conn->prepare("SELECT * FROM produse WHERE store_id = ? ORDER BY id_produs DESC");
    $stmt->bind_param("i", $storeId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $produse[] = $row;
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Magazin - <?= htmlspecialchars($storeName) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            margin: 0;
            background-color: #f0fdfb;
        }
        .sidebar {
            width: 240px;
            background: #17a2b8;
            min-height: 100vh;
            float: left;
            color: white;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        .sidebar li {
            padding: 15px 20px;
        }
        .sidebar li a, .sidebar li button {
            color: white;
            text-decoration: none;
            display: block;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            padding: 0;
            font-weight: bold;
        }
        .sidebar li:hover {
            background: #138496;
        }
        .content {
            margin-left: 240px;
            padding: 30px;
        }
        .section {
            display: none;
        }
        .btn-success { background-color: #28a745; border-color: #28a745; }
        .btn-warning { background-color: #ffc107; border-color: #ffc107; }
        .btn-danger { background-color: #dc3545; border-color: #dc3545; }
    </style>
    <script>
        function toggleForm() {
            const form = document.getElementById('addProductForm');
            form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
        }

        function showSection(id) {
            document.querySelectorAll('.section').forEach(s => s.style.display = 'none');
            document.getElementById(id).style.display = 'block';
        }

        window.onload = function () {
            const url = new URL(window.location.href);
            const section = url.searchParams.get("section") || "dashboard";
            showSection(section);
        }
    </script>
</head>
<body>
<div class="sidebar">
    <ul>
        <li><a href="#" onclick="showSection('dashboard')"><i class="fas fa-home"></i> Dashboard</a></li>
        <li><a href="#" onclick="showSection('produse')"><i class="fas fa-box"></i> Produse</a></li>
        <li><a href="#" onclick="showSection('comenzi')"><i class="fas fa-shopping-cart"></i> Comenzi</a></li>
        <li><a href="#" onclick="showSection('clienti')"><i class="fas fa-users"></i> Clienți</a></li>
        <li><a href="#" onclick="showSection('utilizatori')"><i class="fas fa-user-shield"></i> Utilizatori & Roluri</a></li>
        <li><a href="#" onclick="showSection('module')"><i class="fas fa-cogs"></i> Module</a></li>
        <li><a href="#" onclick="showSection('rapoarte')"><i class="fas fa-chart-line"></i> Rapoarte</a></li>
        <li><a href="#" onclick="showSection('personalizare')"><i class="fas fa-paint-brush"></i> Personalizare</a></li>
        <li>
            <form action="../../settings/update_dashboard.php" method="post" onsubmit="return confirm('Ești sigur că vrei să actualizezi dashboard-ul magazinului?')">
                <input type="hidden" name="store_name" value="<?= htmlspecialchars($storeName) ?>">
                <button type="submit"><i class="fas fa-sync-alt"></i> Update Dashboard</button>
            </form>
        </li>
        <li><a href="<?= $storePublicUrl ?>" target="_blank"><i class="fas fa-store"></i> Vezi magazinul</a></li>
        <li><a href="/my-saas-app/public/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</div>

<div class="content">
    <div id="dashboard" class="section">
        <?php if (isset($_GET['updated'])): ?>
            <div class="alert alert-success">✔️ Dashboard-ul a fost actualizat cu succes!</div>
        <?php endif; ?>
        <h2>👋 Bun venit în dashboard-ul magazinului <strong><?= htmlspecialchars($storeName) ?></strong></h2>
        <p>Aici poți gestiona produse, comenzi, clienți și multe altele.</p>
    </div>

    <div id="produse" class="section">
        <h2>📦 Produse</h2>
        <button class="btn btn-success mb-3" onclick="toggleForm()">Adaugă produs nou</button>

        <form id="addProductForm" action="../../settings/process_add_product.php" method="POST" enctype="multipart/form-data" class="mb-4" style="display: none;">
            <input type="hidden" name="store_id" value="<?= $storeId ?>">
            <div class="form-row">
                <div class="col"><input type="text" name="denumire" class="form-control" placeholder="Nume produs" required></div>
                <div class="col"><input type="text" name="pret" class="form-control" placeholder="Preț" required></div>
                <div class="col"><input type="text" name="UM" class="form-control" placeholder="Unitate" required></div>
                <div class="col"><input type="number" name="stoc" class="form-control" placeholder="Stoc" required></div>
                <div class="col"><input type="number" name="stoc_limitat" class="form-control" placeholder="Limită stoc" required></div>
            </div>
            <div class="form-group mt-2">
                <textarea name="descriere" class="form-control" rows="3" placeholder="Descriere"></textarea>
            </div>
            <div class="form-group">
                <label>Imagine produs</label>
                <input type="file" name="image" class="form-control-file">
            </div>
            <button type="submit" class="btn btn-success">Adaugă produs</button>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-white">
                <thead class="thead-light">
                    <tr>
                        <th>Imagine</th>
                        <th>Nume</th>
                        <th>Preț</th>
                        <th>Unitate</th>
                        <th>Stoc</th>
                        <th>Limită</th>
                        <th>Descriere</th>
                        <th>Acțiuni</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produse as $produs): ?>
                    <tr>
                        <td><?php if (!empty($produs['pic'])): ?><img src="/my-saas-app/public/images/<?= htmlspecialchars($produs['pic']) ?>" width="50"><?php endif; ?></td>
                        <td><?= htmlspecialchars($produs['denumire']) ?></td>
                        <td><?= htmlspecialchars($produs['pret']) ?> lei</td>
                        <td><?= htmlspecialchars($produs['UM']) ?></td>
                        <td><?= htmlspecialchars($produs['stoc']) ?></td>
                        <td><?= htmlspecialchars($produs['stoc_limitat']) ?></td>
                        <td><?= htmlspecialchars($produs['descriere']) ?></td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="../../settings/edit_product.php?id=<?= $produs['id_produs'] ?>&store=<?= urlencode($storeName) ?>" class="btn btn-warning btn-sm mr-1">Editează</a>
                                <form method="POST" action="../../settings/delete_product.php" onsubmit="return confirm('Sigur dorești să ștergi acest produs?');">
                                    <input type="hidden" name="delete_id" value="<?= $produs['id_produs'] ?>">
                                    <input type="hidden" name="store_name" value="<?= htmlspecialchars($storeName) ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Șterge</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="personalizare" class="section">
        <h2>🎨 Personalizare Magazin</h2>
        <form action="../../settings/update_store_style.php" method="POST">
            <input type="hidden" name="store_id" value="<?= $storeId ?>">
            <input type="hidden" name="store_name" value="<?= $storeName ?>">

            <div class="form-group">
                <label>Titlu magazin:</label>
                <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($settings['title']) ?>" placeholder="Ex: Taraba Verde">
            </div>

            <div class="form-group">
                <label>Slogan:</label>
                <input type="text" name="slogan" class="form-control" value="<?= htmlspecialchars($settings['slogan']) ?>" placeholder="Ex: Fructe și legume direct de la fermieri">
            </div>

            <div class="form-group">
                <label>Culoare header (afișare publică):</label>
                <input type="color" name="header_color" class="form-control" value="<?= htmlspecialchars($settings['header_color']) ?>">
            </div>

            <div class="form-group">
                <label>Culoare fundal pagină (afișare publică):</label>
                <input type="color" name="background_color" class="form-control" value="<?= htmlspecialchars($settings['background_color']) ?>">
            </div>

            <button type="submit" class="btn btn-primary">Salvează modificările</button>
        </form>
    </div>
</div>
</body>
</html>
