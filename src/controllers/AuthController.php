<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../classes/User.php';

class AuthController {
    private $pdo;
    private $user;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->user = new User($pdo);
    }

    public function register($username, $email, $password, $confirmPassword) {
        if ($password !== $confirmPassword) {
            return "Пароли не совпадают.";
        }

        if ($this->user->register($username, $email, $password)) {
            header("Location: login.php");
            exit();
        } else {
            return "Ошибка регистрации. Возможно, такой email уже используется.";
        }
    }

    public function login($email, $password) {
        $userId = $this->user->login($email, $password);
        if ($userId) {
            session_start();
            $_SESSION['user_id'] = $userId;
            header("Location: profile.php");
            exit();
        } else {
            return "Неверный email или пароль.";
        }
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }
}
