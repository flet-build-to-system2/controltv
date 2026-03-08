<?php
require_once __DIR__ . '/../config/database.php';

class DashboardController {
    public static function index() {
        $pdo = Database::getConnection();

        // Counts
        $counts = [
            'categories' => $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn(),
            'channels' => $pdo->query("SELECT COUNT(*) FROM channels")->fetchColumn(),
            'movies' => $pdo->query("SELECT COUNT(*) FROM movies")->fetchColumn(),
            'anime' => $pdo->query("SELECT COUNT(*) FROM anime")->fetchColumn()
        ];

        // Recent channels
        $recentChannels = $pdo->query("SELECT c.*, cat.name as category_name FROM channels c LEFT JOIN categories cat ON c.category_id = cat.id ORDER BY c.created_at DESC LIMIT 5")->fetchAll();

        // Recent movies
        $recentMovies = $pdo->query("SELECT m.*, cat.name as category_name FROM movies m LEFT JOIN categories cat ON m.category_id = cat.id ORDER BY m.created_at DESC LIMIT 5")->fetchAll();

        return [
            'counts' => $counts,
            'recentChannels' => $recentChannels,
            'recentMovies' => $recentMovies
        ];
    }
}
?>