<?php
session_start();

require_once __DIR__ . '/../app/Controllers/InstallController.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../routes/web.php';
require_once __DIR__ . '/../routes/api.php';
require_once __DIR__ . '/../routes/install.php';

if (!InstallController::isInstalled()) {
    handleInstallRoutes();
    exit;
}

if ($_GET['page'] === 'login') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (AuthController::login($_POST['email'], $_POST['password'])) {
            header('Location: index.php?page=dashboard');
            exit;
        } else {
            header('Location: index.php?page=login&error=1');
            exit;
        }
    } else {
        include __DIR__ . '/../views/auth/login.php';
    }
} elseif (!AuthController::isLoggedIn()) {
    header('Location: index.php?page=login');
    exit;
} else {
    handleWebRoutes();
}
?>