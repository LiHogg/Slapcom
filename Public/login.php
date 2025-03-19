<?php
include __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../src/controllers/AuthController.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$auth = new AuthController($pdo);
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error = $auth->login($_POST['email'], $_POST['password']);
}

?>

<section class="auth-section">
    <h2>Вход в аккаунт</h2>

    <?php if (!empty($error)): ?>
        <p class="error-message"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form action="login.php" method="POST" class="auth-form">
        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Пароль:</label>
        <input type="password" name="password" required>

        <button type="submit" class="btn">Войти</button>
    </form>

    <p>Нет аккаунта? <a href="register.php">Создайте его</a></p>
</section>

<?php include __DIR__ . '/../templates/footer.php'; ?>
