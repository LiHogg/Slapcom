<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../classes/Message.php';

class MessageController {
    private $pdo;
    private $message;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->message = new Message($pdo);
    }

    public function sendMessage($senderId, $recipientId, $content) {
        if (empty(trim($content))) {
            return "Сообщение не может быть пустым.";
        }
        return $this->message->sendMessage($senderId, $recipientId, $content);
    }

    public function getMessages($userId, $recipientId) {
        return $this->message->getMessages($userId, $recipientId);
    }

    public function getUsernameById($userId) {
        return $this->message->getUsernameById($userId);
    }
}
