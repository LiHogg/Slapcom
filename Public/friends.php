<?php
include '../templates/header.php';
require_once __DIR__ . '/../src/controllers/FriendController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$friendController = new FriendController($pdo);

// Обработка запроса на добавление в друзья
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['friend_id'])) {
    $friendId = intval($_POST['friend_id']);
    $message = $friendController->addFriend($userId, $friendId);
}

// Обработка запроса на удаление из друзей
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_friend_id'])) {
    $friendId = intval($_POST['remove_friend_id']);
    $message = $friendController->removeFriend($userId, $friendId);
}

// Получение списка друзей
$friends = $friendController->getFriends($userId);

// Получение списка всех пользователей (кроме текущего пользователя)
$stmt = $pdo->prepare("SELECT id, username FROM users WHERE id != ?");
$stmt->execute([$userId]);
$users = $stmt->fetchAll();
?>

<section class="friends-section">
    <h2>Мои друзья</h2>

    <?php if (!empty($message)): ?>
        <p class="success-message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <?php if (empty($friends)): ?>
        <p>У вас пока нет друзей.</p>
    <?php else: ?>
        <ul class="friends-list">
            <?php foreach ($friends as $friend): ?>
                <li>
                    <?= htmlspecialchars($friend['username']) ?>
                    <form action="friends.php" method="POST" style="display:inline;">
                        <input type="hidden" name="remove_friend_id" value="<?= $friend['id'] ?>">
                        <button type="submit" class="btn-danger">Удалить</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <h2>Добавить друга</h2>
    <form action="friends.php" method="POST" class="add-friend-form">
        <select name="friend_id" required>
            <?php foreach ($users as $user): ?>
                <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['username']) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn">Добавить</button>
    </form>
</section>

<?php include '../templates/footer.php'; ?>
