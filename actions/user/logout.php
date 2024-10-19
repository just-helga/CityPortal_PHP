<?php

require_once __DIR__ . '/../../app/requires.php';

//Проверка метода, с помощью которого осуществлен переход на данный файл
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    unset($_SESSION['user']);
    session_destroy();
    header('Location: /login.php');
} else {
    echo 'Error handle action';
}
