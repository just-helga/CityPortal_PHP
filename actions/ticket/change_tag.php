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
$tag = (int)$_POST['tag'];
$user_role = (int)$_POST['user_role'];

//проверка наличия указанного тега в БД
$query = $db->prepare("SELECT * FROM `tags` WHERE `id` = :id");
$query->execute(['id' => $tag]);
$tagExists = $query->fetch();
if (!$tagExists) {
    echo 'Error handle action';
    die();
}

//поиск завяки в БД
$query = $db->prepare("SELECT `user_id` FROM `tickets` WHERE `id` = :id");
$query->execute(['id' => $id]);
$ticket = $query->fetch(PDO::FETCH_ASSOC);

//проверка роли пользователя, изменяющего статус заявки
if ($user_role != $config['admin_role']) {
    echo 'Error handle action';
    die();
}

//смена статуса заявки в БД
$query = $db->prepare("UPDATE `tickets` SET `tag_id` = :tag WHERE `id` = :id");
$query->execute([
    'id' => $id,
    'tag' => $tag
]);

//переадресация на страницу управления заявками
header('Location: /tickets-control.php');