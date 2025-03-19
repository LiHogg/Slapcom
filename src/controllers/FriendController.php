<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../classes/Friend.php';

class FriendController {
    private $pdo;
    private $friend;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->friend = new Friend($pdo);
    }

    public function addFriend($userId, $friendId) {
        if ($this->friend->addFriend($userId, $friendId)) {
            return "Пользователь добавлен в друзья.";
        } else {
            return "Ошибка: уже друзья или произошла ошибка.";
        }
    }

    public function removeFriend($userId, $friendId) {
        if ($this->friend->removeFriend($userId, $friendId)) {
            return "Пользователь удален из друзей.";
        } else {
            return "Ошибка при удалении друга.";
        }
    }

    public function getFriends($userId) {
        return $this->friend->getFriends($userId);
    }
}
