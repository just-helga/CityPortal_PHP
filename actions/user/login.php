<?php

//подключение сессии
session_start();
//подключение необходимых файлов
require_once __DIR__ . '/../../app/requires.php';

//получение данных с формы
$email = $_POST['email'];
$password = $_POST['password'];

//массив с полями формы для валидации
$fields = [
    'email' => [
        'value' => $email,
        'error' => false,
        'message' => ''
    ],
    'password' => [
        'value' => $password,
        'error' => false,
        'message' => ''
    ]
];

//валидация поля Email
if (empty($email)) {
    $fields['email']['error'] = true;
    $fields['email']['message'] = 'Заполните поле Email';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $fields['email']['error'] = true;
    $fields['email']['message'] = 'Введите адрес электронной почты';
}
//валидация поля Пароль
if (empty($password)) {
    $fields['password']['error'] = true;
    $fields['password']['message'] = 'Заполните поле Пароль';
}

//проверка налиция ошибок валидации
foreach ($fields as $field) {
    if($field['error'] == true) {
        $_SESSION['message'] = 'Проверьте правильность введенных данных';
        $_SESSION['messageType'] = 'danger';
        $_SESSION['fields'] = $fields;
        header('Location: /register.php');
        die();
    }
}

//подготовка запроса в БД
$query = $db->prepare("SELECT * FROM `users` WHERE `email` = :email");
//запрос в БД
$query->execute([
    'email' => $email,
]);
//получение пользователя из БД
$user = $query->fetch(PDO::FETCH_ASSOC);

//проверка наличия пользователя с указанным email и паролем в БД
if (!$user || !password_verify($password, $user['password'])) {
    $fields['email']['error'] = true;
    $fields['password']['error'] = true;
    $_SESSION['fields'] = $fields;
    $_SESSION['message'] = 'Неверный email или пароль';
    $_SESSION['messageType'] = 'danger';
    header('Location: /login.php');
    die();
}

//занесение id пользователя в сессию
$_SESSION['user'] = $user['id'];
header('Location: /');