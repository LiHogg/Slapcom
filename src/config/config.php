<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'slapcom');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_CHARSET', 'utf8mb4');

define('BASE_URL', 'http://localhost/social_network');
define('SESSION_LIFETIME', 3600);

// Проверяем, запущена ли сессия
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Обновление времени жизни сессии
if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} elseif (time() - $_SESSION['CREATED'] > SESSION_LIFETIME) {
    session_regenerate_id(true);
    $_SESSION['CREATED'] = time();
}
