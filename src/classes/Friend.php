<?php
class Friend {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addFriend($userId, $friendId) {
        // Проверяем, есть ли уже дружба
        $stmt = $this->pdo->prepare("SELECT * FROM friends WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)");
        $stmt->execute([$userId, $friendId, $friendId, $userId]);

        if ($stmt->fetch()) {
            return false; // Уже друзья
        }

        // Добавляем в друзья
        $stmt = $this->pdo->prepare("INSERT INTO friends (user_id, friend_id) VALUES (?, ?)");
        return $stmt->execute([$userId, $friendId]);
    }

    public function removeFriend($userId, $friendId) {
        $stmt = $this->pdo->prepare("DELETE FROM friends WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)");
        return $stmt->execute([$userId, $friendId, $friendId, $userId]);
    }

    public function getFriends($userId) {
        $stmt = $this->pdo->prepare("
            SELECT users.id, users.username
            FROM friends
            INNER JOIN users ON users.id = friends.friend_id
            WHERE friends.user_id = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}
