<?php
class AuthMiddleware {
    public static function isAuthenticated() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
            exit();
        }
    }

    public static function isAdmin() {
        self::isAuthenticated();
        if ($_SESSION['user_role'] !== 'admin') {
            header('Location: home');
            exit();
        }
    }

    public static function isFirstAdmin() {
        self::isAuthenticated();
    
        require_once 'config/database.php';
        $database = new Database();
        $db = $database->connect();
    
        // Ambil admin pertama berdasarkan waktu pendaftaran
        $query = "SELECT id FROM users WHERE role = 'admin' ORDER BY created_at ASC LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // // Jika tidak ada admin pertama atau user sekarang bukan admin pertama, redirect ke home
        // if (!$result || $_SESSION['user_id'] != $result['id']) {
        //     header('Location: home');
        //     exit();
        // }
    }

    public static function isGuest() {
        if (isset($_SESSION['user_id'])) {
            header('Location: home');
            exit();
        }
    }
}