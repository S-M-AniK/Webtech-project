<?php
// App/controllers/UserController.php
require_once ROOT_PATH . '/App/core/Database.php';
require_once ROOT_PATH . '/App/models/User.php';

class UserController {
    private $userModel;

    public function __construct() {
        $database = new Database();
        $this->userModel = new User($database->getConnection());
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim(htmlspecialchars($_POST['username']));
            $email = trim(htmlspecialchars($_POST['email']));
            $password = trim($_POST['password']);
            
            if (empty($username) || empty($email) || empty($password)) {
                die('Please fill out all fields.');
            }

            $result = $this->userModel->create($username, $email, $password);

            if ($result === true) {
                header('location: index.php?page=home&status=reg_success');
                exit();
            } else {
                die($result);
            }
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim(htmlspecialchars($_POST['email']));
            $password = trim($_POST['password']);
            $user = $this->userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                // Password is correct, so set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['username'];
                $_SESSION['user_role'] = $user['role'];
                
                // Check the user's role and redirect accordingly
                if ($user['role'] === 'admin') {
                    header('location: index.php?page=admin-dashboard');
                } elseif ($user['role'] === 'author') {
                    // This is the updated link for the new author panel
                    header('location: index.php?page=author-panel');
                } else {
                    header('location: index.php?page=home');
                }
                exit();

            } else {
                // Invalid credentials
                die('Invalid email or password.');
            }
        }
    }

    public function logout() {
        $_SESSION = array();
        session_destroy();
        header('location: index.php?page=home');
        exit();
    }
}