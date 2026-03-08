<?php
// Dashboard routes
function handleWebRoutes() {
    $page = $_GET['page'] ?? 'dashboard';
    $action = $_GET['action'] ?? 'index';
    $id = $_GET['id'] ?? null;

    switch ($page) {
        case 'dashboard':
            if ($action === 'index') {
                $data = DashboardController::index();
                include __DIR__ . '/../views/layouts/header.php';
                include __DIR__ . '/../views/dashboard/index.php';
                include __DIR__ . '/../views/layouts/footer.php';
            }
            break;
        case 'categories':
            if ($action === 'index') {
                $categories = CategoryController::index();
                include __DIR__ . '/../views/layouts/header.php';
                include __DIR__ . '/../views/categories/form.php';
                include __DIR__ . '/../views/layouts/footer.php';
            } elseif ($action === 'store' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                CategoryController::store($_POST['name'], $_POST['type']);
                header('Location: index.php?page=categories');
            } elseif ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                CategoryController::update($id, $_POST['name'], $_POST['type']);
                header('Location: index.php?page=categories');
            } elseif ($action === 'delete') {
                CategoryController::delete($id);
                header('Location: index.php?page=categories');
            }
            break;
        case 'channels':
            if ($action === 'index') {
                $channels = ChannelController::index();
                include __DIR__ . '/../views/layouts/header.php';
                include __DIR__ . '/../views/channels/index.php';
                include __DIR__ . '/../views/layouts/footer.php';
            } elseif ($action === 'create') {
                $categories = CategoryController::index();
                include __DIR__ . '/../views/layouts/header.php';
                include __DIR__ . '/../views/channels/form.php';
                include __DIR__ . '/../views/layouts/footer.php';
            } elseif ($action === 'edit') {
                $channel = ChannelController::getById($id);
                $categories = CategoryController::index();
                include __DIR__ . '/../views/layouts/header.php';
                include __DIR__ . '/../views/channels/form.php';
                include __DIR__ . '/../views/layouts/footer.php';
            } elseif ($action === 'store' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                $logo = isset($_FILES['logo']) ? ChannelController::uploadLogo($_FILES['logo']) : null;
                ChannelController::store($_POST['name'], $_POST['m3u_link'], $_POST['category_id'], $_POST['status'], $logo);
                header('Location: index.php?page=channels');
            } elseif ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                $logo = isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK ? ChannelController::uploadLogo($_FILES['logo']) : null;
                ChannelController::update($id, $_POST['name'], $_POST['m3u_link'], $_POST['category_id'], $_POST['status'], $logo);
                header('Location: index.php?page=channels');
            } elseif ($action === 'delete') {
                ChannelController::delete($id);
                header('Location: index.php?page=channels');
            }
            break;
        // Similar for movies, anime, ads, settings
        case 'logout':
            AuthController::logout();
            break;
        default:
            // 404 or redirect to dashboard
            header('Location: index.php?page=dashboard');
            break;
    }
}
?>