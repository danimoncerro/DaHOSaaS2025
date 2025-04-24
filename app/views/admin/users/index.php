<h2>Gestionare Utilizatori</h2>

<table class="table">
    <thead>
        <tr>
            <th>Email</th>
            <th>Rol</th>
            <th>Acțiune</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <form method="POST" action="/my-saas-app/public/index.php?url=admin/users/updateRole">
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td>
                        <select name="role" class="form-control">
                            <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="superadmin" <?= $user['role'] === 'superadmin' ? 'selected' : '' ?>>Superadmin</option>
                        </select>
                    </td>
                    <td>
                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-primary">Salvează</button>
                    </td>
                </form>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
