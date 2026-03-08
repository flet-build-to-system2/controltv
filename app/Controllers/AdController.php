<?php
require_once __DIR__ . '/../config/database.php';

class AdController {
    public static function index() {
        $pdo = Database::getConnection();
        return $pdo->query("SELECT * FROM ad_settings ORDER BY network_name ASC")->fetchAll();
    }

    public static function save($network_name, $settings_json, $is_active) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO ad_settings (network_name, settings_json, is_active) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE settings_json = VALUES(settings_json), is_active = VALUES(is_active)");
        return $stmt->execute([$network_name, $settings_json, $is_active]);
    }

    public static function delete($network_name) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM ad_settings WHERE network_name = ?");
        return $stmt->execute([$network_name]);
    }

    public static function getActiveAds() {
        $pdo = Database::getConnection();
        return $pdo->query("SELECT * FROM ad_settings WHERE is_active = 1")->fetchAll();
    }
}
?>