<?php
class Database {
    private static $pdo = null;

    public static function getConnection() {
        if (self::$pdo === null) {
            $envFile = __DIR__ . '/../.env';
            if (!file_exists($envFile)) {
                die('Database configuration not found. Please run the installer.');
            }

            $env = parse_ini_file($envFile);
            if (!$env) {
                die('Failed to parse .env file.');
            }

            $host = $env['DB_HOST'] ?? 'localhost';
            $name = $env['DB_NAME'] ?? '';
            $user = $env['DB_USER'] ?? '';
            $pass = $env['DB_PASS'] ?? '';

            try {
                self::$pdo = new PDO("mysql:host=$host;dbname=$name;charset=utf8mb4", $user, $pass);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die('Database connection failed: ' . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
?>