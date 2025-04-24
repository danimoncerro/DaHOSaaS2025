<?php

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isSuperAdmin() {
    return isLoggedIn() && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'superadmin';
}

function isStoreAdmin() {
    return isLoggedIn() && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

function requireSuperAdmin() {
    if (!isSuperAdmin()) {
        header('Location: /my-saas-app/public/login.php');
        exit;
    }
}

function requireStoreAdmin() {
    if (!isStoreAdmin()) {
        header('Location: /my-saas-app/public/login.php');
        exit;
    }
}
