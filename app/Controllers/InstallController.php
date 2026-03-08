<?php
require_once __DIR__ . '/../config/database.php';

class InstallController {
    public static function isInstalled() {
        $envFile = __DIR__ . '/../.env';
        if (!file_exists($envFile)) return false;
        $env = parse_ini_file($envFile);
        return isset($env['INSTALLED']) && $env['INSTALLED'] === 'true';
    }

    public static function checkRequirements() {
        $requirements = [
            'php_version' => version_compare(PHP_VERSION, '7.4', '>='),
            'pdo' => extension_loaded('pdo'),
            'pdo_mysql' => extension_loaded('pdo_mysql'),
            'mbstring' => extension_loaded('mbstring'),
            'json' => extension_loaded('json'),
            'writable_env' => is_writable(__DIR__ . '/../'),
            'writable_uploads' => is_writable(__DIR__ . '/../public/uploads/')
        ];
        return $requirements;
    }

    public static function testDatabaseConnection($host, $name, $user, $pass) {
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$name;charset=utf8mb4", $user, $pass);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function install($db_host, $db_name, $db_user, $db_pass, $admin_email, $admin_pass) {
        // Create .env
        $envContent = "DB_HOST=$db_host\nDB_NAME=$db_name\nDB_USER=$db_user\nDB_PASS=$db_pass\nAPP_NAME=StreamVault\nAPP_URL=\nMAINTENANCE_MODE=false\nINSTALLED=true\n";
        file_put_contents(__DIR__ . '/../.env', $envContent);

        // Connect and run SQL
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = file_get_contents(__DIR__ . '/../install.sql');
        $pdo->exec($sql);

        // Create admin
        $hashedPass = password_hash($admin_pass, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO admins (email, password, role) VALUES (?, ?, 'super_admin')");
        $stmt->execute([$admin_email, $hashedPass]);

        return true;
    }
}
?>