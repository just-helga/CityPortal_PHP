<?php

//подключение сессии
session_start();
//подключение необходимых файлов
require_once __DIR__ . '/../../app/requires.php';
$config = require_once __DIR__ . '/../../config/app.php';

//получение данных с формы
$email = $_POST['email'];
$name = $_POST['name'];
$dob = $_POST['dob'];
$password = $_POST['password'];
$confirm = $_POST['password_confirmation'];

//массив с полями формы для валидации
$fields = [
    'email' => [
        'value' => $email,
        'error' => false,
        'message' => ''
    ],
    'name' => [
        'value' => $name,
        'error' => false,
        'message' => ''
    ],
    'dob' => [
        'value' => $dob,
        'error' => false,
        'message' => ''
    ],
    'password' => [
        'value' => $password,
        'error' => false,
        'message' => ''
    ],
    'confirm' => [
        'value' => $confirm,
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
//валидация поля ФИО
if (empty($name)) {
    $fields['name']['error'] = true;
    $fields['name']['message'] = 'Заполните поле ФИО';
}
//валидация поля Дата рождения
if (empty($dob)) {
    $fields['dob']['error'] = true;
    $fields['dob']['message'] = 'Заполните поле Дата рождения';
}
//валидация поля Пароль
if (empty($password) || empty($confirm)) {
    $fields['password']['error'] = true;
    $fields['password']['message'] = 'Заполните поле Пароль';
} elseif ($password !== $confirm) {
    $fields['password']['error'] = true;
    $fields['password']['message'] = 'Пароли не совпадают';
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

//запрос в БД
$query = $db->prepare("INSERT INTO `users`(`email`, `name`, `dob`, `password`, `role_id`) VALUES (:email, :name, :dob, :password, :role_id)");
try {
    $query->execute([
        'email' => $email,
        'name' => $name,
        'dob' => $dob,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'role_id' => $config['default_role']
    ]);
    $_SESSION['message'] = 'Регистрация прошла успешно';
    $_SESSION['messageType'] = 'success';
    header('Location: /login.php');
} catch (\PDOException $exception) {
    echo $exception->getMessage();
    $_SESSION['message'] = 'Ошибка при регистрации';
    $_SESSION['messageType'] = 'danger';
    header('Location: /register.php');
}