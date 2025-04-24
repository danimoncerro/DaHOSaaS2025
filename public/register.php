<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Înregistrare - DaHo Tech Solutions</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0fdfb;
            font-family: 'Segoe UI', Tahoma, sans-serif;
        }
        header {
            background-color: #17a2b8;
            color: white;
            padding: 20px 30px;
            display: flex;
            align-items: center;
        }
        .logo {
            height: 80px;
            margin-right: 20px;
        }
        header h1 {
            margin: 0;
        }
        .btn-primary {
            background-color: #28a745;
            border-color: #28a745;
        }
        footer {
            background-color: #222;
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <img src="images/logo.png" alt="DaHo Logo" class="logo">
        <h1>Înregistrare</h1>
    </header>

    <main class="container my-5">
        <form action="register_process.php" method="post" class="needs-validation" novalidate>
            <div class="form-group">
                <label for="first_name">Prenume:</label>
                <input type="text" id="first_name" name="first_name" class="form-control" required>
                <div class="invalid-feedback">Te rugăm să introduci prenumele.</div>
            </div>
            <div class="form-group">
                <label for="last_name">Nume:</label>
                <input type="text" id="last_name" name="last_name" class="form-control" required>
                <div class="invalid-feedback">Te rugăm să introduci numele.</div>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
                <div class="invalid-feedback">Te rugăm să introduci un email valid.</div>
            </div>
            <div class="form-group">
                <label for="password">Parolă:</label>
                <input type="password" id="password" name="password" class="form-control" required>
                <div class="invalid-feedback">Te rugăm să introduci o parolă.</div>
            </div>
            <button type="submit" class="btn btn-primary">Înregistrare</button>
        </form>
    </main>

    <footer class="text-center py-3">
        <p>&copy; 2025 DaHo Tech Solutions. Toate drepturile rezervate.</p>
    </footer>

    <!-- Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Atenție</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Există deja un utilizator cu această adresă de email!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Închide</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        <?php if (isset($_GET['error']) && $_GET['error'] == 'email_exists'): ?>
        $(document).ready(function() {
            $('#errorModal').modal('show');
        });
        <?php endif; ?>
    </script>
</body>
</html>
