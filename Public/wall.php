<?php
session_start();
require_once __DIR__ . '/../src/controllers/PostController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$postController = new PostController($pdo);

// Добавление нового поста
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
    $content = trim($_POST['content']);
    $message = $postController->createPost($userId, $content);
    header("Location: wall.php");
    exit();
}

// Получение всех постов пользователя
$posts = $postController->getUserPosts($userId);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Стена пользователя</title>
</head>
<body>
<h1>Стена пользователя</h1>
<?php include 'header.php'; ?>
<?php if (!empty($message)): ?>
    <p style="color: green;"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form action="wall.php" method="POST">
    <textarea name="content" placeholder="Напишите что-нибудь..." required></textarea><br>
    <button type="submit">Опубликовать</button>
</form>

<h2>Ваши посты:</h2>
<?php if (empty($posts)): ?>
    <p>У вас пока нет постов.</p>
<?php else: ?>
    <?php foreach ($posts as $post): ?>
        <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
            <p><strong><?= htmlspecialchars($post['username']) ?></strong> (<?= $post['created_at'] ?>):</p>
            <p><?= htmlspecialchars($post['content']) ?></p>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<p><a href="profile.php">Вернуться в профиль</a></p>
<p><a href="logout.php">Выйти</a></p>
</body>
</html>
