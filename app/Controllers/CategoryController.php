<?php
require_once __DIR__ . '/../config/database.php';

class CategoryController {
    public static function index() {
        $pdo = Database::getConnection();
        return $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll();
    }

    public static function getById($id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function store($name, $type) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO categories (name, type) VALUES (?, ?)");
        return $stmt->execute([$name, $type]);
    }

    public static function update($id, $name, $type) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE categories SET name = ?, type = ? WHERE id = ?");
        return $stmt->execute([$name, $type, $id]);
    }

    public static function delete($id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function count() {
        $pdo = Database::getConnection();
        return $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
    }
}
?>