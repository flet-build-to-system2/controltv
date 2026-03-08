<?php
require_once __DIR__ . '/../config/database.php';

class Movie {
    public static function getAll() {
        $pdo = Database::getConnection();
        return $pdo->query("SELECT m.*, cat.name as category_name FROM movies m LEFT JOIN categories cat ON m.category_id = cat.id ORDER BY m.created_at DESC")->fetchAll();
    }

    public static function getById($id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT m.*, cat.name as category_name FROM movies m LEFT JOIN categories cat ON m.category_id = cat.id WHERE m.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function create($title, $description, $release_year, $poster, $video_url, $category_id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO movies (title, description, release_year, poster, video_url, category_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $description, $release_year ?: null, $poster, $video_url, $category_id ?: null]);
        return $pdo->lastInsertId();
    }

    public static function update($id, $title, $description, $release_year, $poster, $video_url, $category_id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE movies SET title = ?, description = ?, release_year = ?, poster = ?, video_url = ?, category_id = ? WHERE id = ?");
        return $stmt->execute([$title, $description, $release_year ?: null, $poster, $video_url, $category_id ?: null, $id]);
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
}
?>