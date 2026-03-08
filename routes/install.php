<?php
function handleInstallRoutes() {
    $step = $_GET['step'] ?? 1;
    $current_step = $step;

    switch ($step) {
        case 1:
            $requirements = InstallController::checkRequirements();
            include __DIR__ . '/../views/install/layout.php';
            include __DIR__ . '/../views/install/step1_requirements.php';
            break;
        case 2:
            if (isset($_GET['test'])) {
                $result = InstallController::testDatabaseConnection($_POST['db_host'], $_POST['db_name'], $_POST['db_user'], $_POST['db_pass']);
                header('Content-Type: application/json');
                if ($result === true) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => $result]);
                }
                exit;
            }
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Save to session
                $_SESSION['db_host'] = $_POST['db_host'];
                $_SESSION['db_name'] = $_POST['db_name'];
                $_SESSION['db_user'] = $_POST['db_user'];
                $_SESSION['db_pass'] = $_POST['db_pass'];
                header('Location: install.php?step=3');
                exit;
            }
            include __DIR__ . '/../views/install/layout.php';
            include __DIR__ . '/../views/install/step2_database.php';
            break;
        case 3:
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $_SESSION['admin_email'] = $_POST['admin_email'];
                $_SESSION['admin_pass'] = $_POST['admin_pass'];
                header('Location: install.php?step=4');
                exit;
            }
            include __DIR__ . '/../views/install/layout.php';
            include __DIR__ . '/../views/install/step3_admin.php';
            break;
        case 4:
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // AJAX install
                $result = InstallController::install($_SESSION['db_host'], $_SESSION['db_name'], $_SESSION['db_user'], $_SESSION['db_pass'], $_SESSION['admin_email'], $_SESSION['admin_pass']);
                if ($result) {
                    session_destroy();
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false]);
                }
                exit;
            }
            include __DIR__ . '/../views/install/layout.php';
            include __DIR__ . '/../views/install/step4_finish.php';
            break;
        default:
            header('Location: install.php?step=1');
            break;
    }
}
?>