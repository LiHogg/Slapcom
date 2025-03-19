
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Социальная сеть</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
    <h1>Добро пожаловать в социальную сеть!</h1>
    <nav>
        <ul>
            <li><a href="index.php">Главная</a></li>
            <?php if ($userLoggedIn): ?>
                <li><a href="profile.php">Профиль</a></li>
                <li><a href="wall.php">Стена</a></li>
                <li><a href="friends.php">Друзья</a></li>
                <li><a href="messages.php">Сообщения</a></li>
                <li><a href="logout.php">Выйти</a></li>
            <?php else: ?>
                <li><a href="login.php">Вход</a></li>
                <li><a href="register.php">Регистрация</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
<main>
