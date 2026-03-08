<?php
require_once __DIR__ . '/../config/database.php';

class Channel {
    public static function getAll() {
        $pdo = Database::getConnection();
        return $pdo->query("SELECT c.*, cat.name as category_name FROM channels c LEFT JOIN categories cat ON c.category_id = cat.id ORDER BY c.created_at DESC")->fetchAll();
    }

    public static function getById($id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT c.*, cat.name as category_name FROM channels c LEFT JOIN categories cat ON c.category_id = cat.id WHERE c.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function create($name, $logo, $m3u_link, $category_id, $status) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO channels (name, logo, m3u_link, category_id, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $logo, $m3u_link, $category_id ?: null, $status]);
        return $pdo->lastInsertId();
    }

    public static function update($id, $name, $logo, $m3u_link, $category_id, $status) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE channels SET name = ?, logo = ?, m3u_link = ?, category_id = ?, status = ? WHERE id = ?");
        return $stmt->execute([$name, $logo, $m3u_link, $category_id ?: null, $status, $id]);
    }

    public static function delete($id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM channels WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function count() {
        $pdo = Database::getConnection();
        return $pdo->query("SELECT COUNT(*) FROM channels")->fetchColumn();
    }
}
?>