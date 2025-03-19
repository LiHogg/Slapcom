<?php
include __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../src/controllers/MessageController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$messageController = new MessageController($pdo);

// Получение списка пользователей для общения
$stmt = $pdo->prepare("SELECT id, username FROM users WHERE id != ?");
$stmt->execute([$userId]);
$users = $stmt->fetchAll();

// Получение активного собеседника
$recipientId = isset($_GET['recipient_id']) ? intval($_GET['recipient_id']) : null;
$messages = [];
if ($recipientId) {
    $messages = $messageController->getMessages($userId, $recipientId);
}

// Отправка сообщения
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recipient_id']) && isset($_POST['content'])) {
    $recipientId = intval($_POST['recipient_id']);
    $content = trim($_POST['content']);

    $messageController->sendMessage($userId, $recipientId, $content);
    header("Location: messages.php?recipient_id=" . $recipientId);
    exit();
}
?>

<section class="messages-section">
    <h2>Личные сообщения</h2>

    <h3>Выберите собеседника:</h3>
    <ul class="users-list">
        <?php foreach ($users as $user): ?>
            <li><a href="messages.php?recipient_id=<?= $user['id'] ?>"><?= htmlspecialchars($user['username']) ?></a></li>
        <?php endforeach; ?>
    </ul>

    <?php if ($recipientId): ?>
        <h3>Чат с <?= htmlspecialchars($messageController->getUsernameById($recipientId)) ?></h3>

        <div class="chat-box">
            <?php if (empty($messages)): ?>
                <p>Сообщений пока нет.</p>
            <?php else: ?>
                <?php foreach ($messages as $msg): ?>
                    <div class="message">
                        <strong><?= htmlspecialchars($msg['sender_name']) ?>:</strong> <?= htmlspecialchars($msg['content']) ?>
                        <small>(<?= $msg['created_at'] ?>)</small>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <form action="messages.php" method="POST" class="message-form">
            <input type="hidden" name="recipient_id" value="<?= $recipientId ?>">
            <textarea name="content" placeholder="Введите сообщение..." required></textarea>
            <button type="submit" class="btn">Отправить</button>
        </form>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/../templates/footer.php'; ?>
