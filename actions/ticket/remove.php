<?php

//подключение сессии
session_start();
//подключение необходимых файлов
require_once __DIR__ . '/../../app/requires.php';
$config = require_once __DIR__ . '/../../config/app.php';

//проверка авторизации
if (!isset($_SESSION['user'])) {
    echo 'Error handle action';
    die();
}

//получение данных с формы
$id = $_POST['id'];
$user_role = (int)$_POST['user_role'];

$query = $db->prepare("SELECT `user_id` FROM `tickets` WHERE `id` = :id");
$query->execute(['id' => $id]);
$ticket = $query->fetch(PDO::FETCH_ASSOC);

if ($ticket['user_id'] !== $_SESSION['user'] && $user_role != $config['admin_role']) {
    echo 'Error handle action';
    die();
}

$query = $db->prepare("DELETE FROM `tickets` WHERE `id` = :id");
$query->execute(['id' => $id]);
header('Location: /my-tickets.php');