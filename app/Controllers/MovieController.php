<?php
require_once __DIR__ . '/../config/database.php';

class MovieController {
    public static function index() {
        $pdo = Database::getConnection();
        return $pdo->query("SELECT m.*, cat.name as category_name FROM movies m LEFT JOIN categories cat ON m.category_id = cat.id ORDER BY m.created_at DESC")->fetchAll();
    }

    public static function getById($id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT m.*, cat.name as category_name FROM movies m LEFT JOIN categories cat ON m.category_id = cat.id WHERE m.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function store($title, $description, $release_year, $video_url, $category_id, $poster = null) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO movies (title, description, release_year, poster, video_url, category_id) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$title, $description, $release_year ?: null, $poster, $video_url, $category_id ?: null]);
    }

    public static function update($id, $title, $description, $release_year, $video_url, $category_id, $poster = null) {
        $pdo = Database::getConnection();
        if ($poster !== null) {
            $stmt = $pdo->prepare("UPDATE movies SET title = ?, description = ?, release_year = ?, poster = ?, video_url = ?, category_id = ? WHERE id = ?");
            return $stmt->execute([$title, $description, $release_year ?: null, $poster, $video_url, $category_id ?: null, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE movies SET title = ?, description = ?, release_year = ?, video_url = ?, category_id = ? WHERE id = ?");
            return $stmt->execute([$title, $description, $release_year ?: null, $video_url, $category_id ?: null, $id]);
        }
    }

    public static function delete($id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM movies WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function count() {
        $pdo = Database::getConnection();
        return $pdo->query("SELECT COUNT(*) FROM movies")->fetchColumn();
    }

    public static function uploadPoster($file) {
        $uploadDir = __DIR__ . '/../../public/uploads/movies/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'mov_' . time() . '_' . uniqid() . '.' . $ext;
        $path = $uploadDir . $filename;
        if (move_uploaded_file($file['tmp_name'], $path)) {
            return 'uploads/movies/' . $filename;
        }
        return null;
    }
}
?>