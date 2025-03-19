<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../classes/Post.php';

class PostController {
    private $pdo;
    private $post;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->post = new Post($pdo);
    }

    public function createPost($userId, $content) {
        if (empty(trim($content))) {
            return "Пост не может быть пустым.";
        }

        if ($this->post->createPost($userId, $content)) {
            return "Пост опубликован!";
        } else {
            return "Ошибка при создании поста.";
        }
    }

    public function getUserPosts($userId) {
        return $this->post->getUserPosts($userId);
    }
}
