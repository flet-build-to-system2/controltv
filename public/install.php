<?php
session_start();

require_once __DIR__ . '/../app/Controllers/InstallController.php';
require_once __DIR__ . '/../routes/install.php';

if (InstallController::isInstalled()) {
    header('Location: index.php');
    exit;
}

handleInstallRoutes();
?>