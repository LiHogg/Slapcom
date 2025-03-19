<?php
require_once __DIR__ . '/../src/controllers/AuthController.php';

session_start();
$auth = new AuthController($pdo);
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error = $auth->register($_POST['username'], $_POST['email'], $_POST['password'], $_POST['confirm_password']);
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
</head>
<body>
<h2>Регистрация</h2>
<?php if ($error): ?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>
<form action="register.php" method="POST">
    <label>Имя пользователя:</label>
    <input type="text" name="username" required><br>

    <label>Email:</label>
    <input type="email" name="email" required><br>

    <label>Пароль:</label>
    <input type="password" name="password" required><br>

    <label>Подтвердите пароль:</label>
    <input type="password" name="confirm_password" required><br>

    <button type="submit">Зарегистрироваться</button>
</form>
</body>
</html>
