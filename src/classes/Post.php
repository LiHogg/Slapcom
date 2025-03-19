<?php
class Post {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createPost($userId, $content) {
        $stmt = $this->pdo->prepare("INSERT INTO posts (user_id, content) VALUES (?, ?)");
        return $stmt->execute([$userId, $content]);
    }

    public function getUserPosts($userId) {
        $stmt = $this->pdo->prepare("
            SELECT posts.*, users.username
            FROM posts
            INNER JOIN users ON posts.user_id = users.id
            WHERE posts.user_id = ?
            ORDER BY posts.created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}
