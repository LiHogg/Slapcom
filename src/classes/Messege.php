<?php
class Message {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function sendMessage($senderId, $recipientId, $content) {
        $stmt = $this->pdo->prepare("INSERT INTO messages (sender_id, recipient_id, content) VALUES (?, ?, ?)");
        return $stmt->execute([$senderId, $recipientId, $content]);
    }

    public function getMessages($userId, $recipientId) {
        $stmt = $this->pdo->prepare("
            SELECT messages.*, users.username AS sender_name 
            FROM messages 
            JOIN users ON messages.sender_id = users.id
            WHERE (sender_id = ? AND recipient_id = ?) OR (sender_id = ? AND recipient_id = ?)
            ORDER BY messages.created_at ASC
        ");
        $stmt->execute([$userId, $recipientId, $recipientId, $userId]);
        return $stmt->fetchAll();
    }

    public function getUsernameById($userId) {
        $stmt = $this->pdo->prepare("SELECT username FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchColumn();
    }
}
