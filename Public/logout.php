<?php
require_once __DIR__ . '/../src/controllers/AuthController.php';

$auth = new AuthController($pdo);
$auth->logout();
