<?php

//подключение сессии
session_start();
//подключение необходимых файлов
require_once __DIR__ . '/../../app/requires.php';
$config =require_once __DIR__ . "/../../config/app.php";

//проверка авторизации
if (!isset($_SESSION['user'])) {
    echo 'Error hundle action';
    die();
}

//получение данных с формы
$title = $_POST['title'];
$description = $_POST['description'];
$image = $_FILES['image'];

//массив с полями формы для валидации
$fields = [
    'title' => [
        'value' => $title,
        'error' => false,
        'message' => ''
    ],
    'description' => [
        'value' => $description,
        'error' => false,
        'message' => ''
    ],
    'image' => [
        'error' => false,
        'message' => ''
    ]
];

//валидация поля Тема заявки
if (empty($title)) {
    $fields['title']['error'] = true;
    $fields['title']['message'] = 'Заполните поле Тема заявки';
}
//валидация поля Описание
if (empty($description)) {
    $fields['description']['error'] = true;
    $fields['description']['message'] = 'Заполните поле Описание';
}
//валидация поля Изображение
$validTypes = ['image/jpeg', 'image/png'];
if ($image['name'] == '' || !in_array($image['type'], $validTypes)) {
    $fields['image']['error'] = true;
    $fields['image']['message'] = 'Прикрепите изображение';
}

//проверка налиция ошибок валидации
foreach ($fields as $field) {
    if($field['error'] == true) {
        $_SESSION['message'] = 'Проверьте правильность введенных данных';
        $_SESSION['messageType'] = 'danger';
        $_SESSION['fields'] = $fields;
        header('Location: /add-ticket.php');
        die();
    }
}

//проверка наличия директории upload, в случае отсутствия - создание
$dir = __DIR__ . '/../../upload';
if (!is_dir($dir)) {
    mkdir($dir);
}

//создание имени файла с расширением
$ext = pathinfo($image['name'], PATHINFO_EXTENSION);
$imageName = uniqid() . ".$ext";
//сохранение файла
move_uploaded_file($image['tmp_name'], "$dir/$imageName");

//запрос в БД
$query = $db->prepare("INSERT INTO `tickets`(`title`, `description`, `image`, `tag_id`, `user_id`) VALUES (:title, :description, :image, :tag_id, :user_id)");
try {
    $query->execute([
        'title' => $title,
        'description' => $description,
        'image' => "upload/$imageName",
        'tag_id' => $config['default_tag'],
        'user_id' => $_SESSION['user']
    ]);
    header('Location: /my-tickets.php');
} catch (\PDOException $exception) {
    echo $exception->getMessage();
    $_SESSION['message'] = 'Ошибка при регистрации';
    $_SESSION['messageType'] = 'danger';
    header('Location: /add-ticket.php');
}
