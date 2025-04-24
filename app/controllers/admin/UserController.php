<?php

namespace app\controllers\admin;

use core\Controller;
use app\models\User;

class UserController extends Controller
{
    public function index()
    {

        echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';
        exit;
        // Verificare dacă utilizatorul este autentificat și are rol de superadmin
        session_start();

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'superadmin') {
            header('Location: /my-saas-app/public/index.php?url=login');
            exit;
        }

        // Afișare view cu lista utilizatorilor (exemplu simplu)
        $users = User::all();

        return $this->view('admin/users/index', [
            'users' => $users
        ]);
    }
}
