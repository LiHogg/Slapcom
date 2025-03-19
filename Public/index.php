<?php
session_start();
require_once __DIR__ . '/../src/config/db.php';

$userLoggedIn = isset($_SESSION['user_id']);

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Социальная сеть</title>
</head>
<body>
<?php include '../templates/header.php'; ?>

<section class="index-section">
    <h2>Добро пожаловать в социальную сеть!</h2>
    <p>Здесь вы можете находить друзей, общаться, публиковать посты и делиться своими мыслями.</p>

    <?php if (isset($_SESSION['user_id'])): ?>
        <p><a class="btn" href="profile.php">Перейти в профиль</a></p>
    <?php else: ?>
        <p><a class="btn" href="register.php">Создать аккаунт</a> или <a class="btn" href="login.php">Войти</a></p>
    <?php endif; ?>
</section>

<?php include '../templates/footer.php'; ?>

</body>
</html>
