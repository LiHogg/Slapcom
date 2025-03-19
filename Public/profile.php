<?php
include __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../src/controllers/ProfileController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$profileController = new ProfileController($pdo);
$userData = $profileController->getUserData($userId);

if (!$userData) {
    die("Ошибка: Пользователь не найден.");
}
?>

<section class="profile-section">
    <h2>Ваш профиль</h2>

    <p><strong>Имя:</strong> <?= htmlspecialchars($userData['username']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($userData['email']) ?></p>

    <?php if (!empty($userData['avatar'])): ?>
        <img src="<?= htmlspecialchars($userData['avatar']) ?>" alt="Аватар" width="100">
    <?php endif; ?>

    <form action="profile.php" method="POST">
        <label>Новое имя:</label>
        <input type="text" name="username" value="<?= htmlspecialchars($userData['username']) ?>" required>

        <label>Новый email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($userData['email']) ?>" required>

        <button type="submit" class="btn">Сохранить изменения</button>
    </form>
</section>

<?php include __DIR__ . '/../templates/footer.php'; ?>
