<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php
    session_start();

    $store_name = isset($_GET['store_name']) ? $_GET['store_name'] : (isset($_SESSION['store_name']) ? $_SESSION['store_name'] : '');

    if (!$store_name) {
        die("Store name is missing! Please check if the URL contains store_name or if the session is set.");
    }
    ?>
    <div class="container">
        <h2>Register</h2>
        <form action="../secure/customer_register.php" method="post">
            <input type="hidden" name="store_name" value="<?php echo htmlspecialchars($store_name); ?>">
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" class="form-control" id="first_name" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" class="form-control" id="last_name" name="last_name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <input type="hidden" name="store_name" value="<?php echo htmlspecialchars($store_name); ?>">
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
</body>
</html>
