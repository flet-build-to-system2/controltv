<?php
require_once __DIR__ . '/../config/database.php';

class AuthController {
    public static function isLoggedIn() {
        session_start();
        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
    }

    public static function login($email, $password) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT id, email, password, role FROM admins WHERE email = ?");
        $stmt->execute([$email]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            session_start();
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_email'] = $admin['email'];
            $_SESSION['admin_role'] = $admin['role'];
            return true;
        }
        return false;
    }

    public static function logout() {
        session_start();
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 3600, '/');
        header('Location: index.php?page=login');
        exit;
    }

    public static function getCurrentAdmin() {
        if (!self::isLoggedIn()) return null;
        return [
            'id' => $_SESSION['admin_id'],
            'email' => $_SESSION['admin_email'],
            'role' => $_SESSION['admin_role']
        ];
    }
}
?>