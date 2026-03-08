<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../app/Controllers/CategoryController.php';
require_once __DIR__ . '/../app/Controllers/ChannelController.php';
require_once __DIR__ . '/../app/Controllers/MovieController.php';
require_once __DIR__ . '/../app/Controllers/AnimeController.php';
require_once __DIR__ . '/../app/Controllers/AdController.php';
// Settings controller not yet, but app_settings

$endpoint = $_GET['endpoint'] ?? '';

switch ($endpoint) {
    case 'categories':
        $data = CategoryController::index();
        echo json_encode(['status' => 'success', 'data' => $data]);
        break;
    case 'channels':
        $data = ChannelController::index();
        echo json_encode(['status' => 'success', 'data' => $data]);
        break;
    case 'movies':
        $data = MovieController::index();
        echo json_encode(['status' => 'success', 'data' => $data]);
        break;
    case 'anime':
        $data = AnimeController::index();
        echo json_encode(['status' => 'success', 'data' => $data]);
        break;
    case 'ads':
        $data = AdController::getActiveAds();
        echo json_encode(['status' => 'success', 'data' => $data]);
        break;
    case 'settings':
        // Get app_settings
        $pdo = Database::getConnection();
        $settings = $pdo->query("SELECT setting_key, setting_value FROM app_settings")->fetchAll(PDO::FETCH_KEY_PAIR);
        echo json_encode(['status' => 'success', 'data' => $settings]);
        break;
    case 'check-update':
        // Placeholder
        $update = [
            'available' => false,
            'version' => '1.0.0',
            'url' => '',
            'message' => '',
            'force' => false
        ];
        echo json_encode(['status' => 'success', 'data' => $update]);
        break;
    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid endpoint']);
        break;
}
?>