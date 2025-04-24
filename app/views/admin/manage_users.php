<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5">
    <h2>Gestionare Utilizatori</h2>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"> <?= $_SESSION['success']; unset($_SESSION['success']); ?> </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"> <?= $_SESSION['error']; unset($_SESSION['error']); ?> </div>
    <?php endif; ?>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nume</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acțiuni</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id']; ?></td>
                    <td><?= $user['first_name'] . ' ' . $user['last_name']; ?></td>
                    <td><?= $user['email']; ?></td>
                    <td>
                        <form method="POST" action="/admin/users/updateRole">
                            <input type="hidden" name="user_id" value="<?= $user['id']; ?>">
                            <select name="role" class="form-control">
                                <option value="user" <?= $user['role'] == 'user' ? 'selected' : ''; ?>>User</option>
                                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                <option value="superadmin" <?= $user['role'] == 'superadmin' ? 'selected' : ''; ?>>Superadmin</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary mt-2">Actualizează</button>
                        </form>
                    </td>
                    <td>
                        <form method="POST" action="/admin/users/delete" onsubmit="return confirm('Sigur dorești să ștergi acest utilizator?');">
                            <input type="hidden" name="user_id" value="<?= $user['id']; ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Șterge</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
