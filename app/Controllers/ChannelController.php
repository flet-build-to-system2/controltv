<?php
require_once __DIR__ . '/../config/database.php';

class ChannelController {
    public static function index() {
        $pdo = Database::getConnection();
        return $pdo->query("SELECT c.*, cat.name as category_name FROM channels c LEFT JOIN categories cat ON c.category_id = cat.id ORDER BY c.created_at DESC")->fetchAll();
    }

    public static function getById($id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT c.*, cat.name as category_name FROM channels c LEFT JOIN categories cat ON c.category_id = cat.id WHERE c.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function store($name, $m3u_link, $category_id, $status, $logo = null) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO channels (name, logo, m3u_link, category_id, status) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$name, $logo, $m3u_link, $category_id ?: null, $status]);
    }

    public static function update($id, $name, $m3u_link, $category_id, $status, $logo = null) {
        $pdo = Database::getConnection();
        if ($logo !== null) {
            $stmt = $pdo->prepare("UPDATE channels SET name = ?, logo = ?, m3u_link = ?, category_id = ?, status = ? WHERE id = ?");
            return $stmt->execute([$name, $logo, $m3u_link, $category_id ?: null, $status, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE channels SET name = ?, m3u_link = ?, category_id = ?, status = ? WHERE id = ?");
            return $stmt->execute([$name, $m3u_link, $category_id ?: null, $status, $id]);
        }
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

    public static function uploadLogo($file) {
        $uploadDir = __DIR__ . '/../../public/uploads/channels/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'ch_' . time() . '_' . uniqid() . '.' . $ext;
        $path = $uploadDir . $filename;
        if (move_uploaded_file($file['tmp_name'], $path)) {
            return 'uploads/channels/' . $filename;
        }
        return null;
    }
}
?>