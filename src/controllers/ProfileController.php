<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../classes/User.php';

class ProfileController {
    private $pdo;
    private $user;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->user = new User($pdo);
    }

    public function getUserData($userId) {
        return $this->user->getUserById($userId);
    }

    public function updateProfile($userId, $username, $email) {
        if (empty(trim($username)) || empty(trim($email))) {
            return "Имя и email не могут быть пустыми.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Неверный формат email.";
        }

        if ($this->user->updateUser($userId, $username, $email)) {
            return "Данные профиля обновлены!";
        } else {
            return "Ошибка при обновлении данных.";
        }
    }

    public function uploadAvatar($userId, $file) {
        $targetDir = "../public/uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = basename($file["name"]);
        $targetFilePath = $targetDir . $userId . "_" . $fileName;
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        $validExtensions = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($imageFileType, $validExtensions)) {
            return "Допустимые форматы изображений: JPG, JPEG, PNG, GIF.";
        }

        if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
            if ($this->user->updateAvatar($userId, $targetFilePath)) {
                return "Аватар успешно обновлен!";
            } else {
                return "Ошибка при обновлении аватара в базе данных.";
            }
        } else {
            return "Ошибка при загрузке файла.";
        }
    }
}
