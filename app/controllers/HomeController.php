<?php
class HomeController {
    private $db;
    private $savingModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        require_once 'app/models/Saving.php';
        $this->savingModel = new Saving($this->db);
    }

    public function index() {
        require_once 'app/helpers/AuthMiddleware.php';
        AuthMiddleware::isAuthenticated();
    
        $isAdmin = $_SESSION['user_role'] === 'admin';
    
        if ($isAdmin) {
            $savings = $this->savingModel->getAll(); // Admin melihat semua donasi
        } else {
            $user_id = $_SESSION['user_id'];
            $savings = $this->savingModel->getSavingsByUser($user_id); // User hanya melihat donasinya sendiri
        }
    
        require_once 'app/views/home.php';
    }
       

    public function admin() {
        require_once 'app/helpers/AuthMiddleware.php';
        AuthMiddleware::isAdmin();
        
        require_once 'app/models/User.php';
        $userModel = new User($this->db);
        $users = $userModel->getAllUsers();
        $saving = $this->savingModel->getAll();
        require_once 'app/views/admin.php';
    }

    public function updateUserRole() {
        require_once 'app/helpers/AuthMiddleware.php';
        AuthMiddleware::isAdmin();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'app/models/User.php';
            $userModel = new User($this->db);
    
            $user_id = $_POST['user_id'];
            $role = $_POST['role'];
    
            if ($userModel->updateRole($user_id, $role)) {
                header('Location: admin');
                exit();
            }
        }
    }
    
    public function deleteUser() {
        require_once 'app/helpers/AuthMiddleware.php';
        AuthMiddleware::isAdmin();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'app/models/User.php';
            $userModel = new User($this->db);
    
            $user_id = $_POST['user_id'];
    
            if ($userModel->deleteUser($user_id)) {
                header('Location: admin');
                exit();
            }
        }
    }
    
}