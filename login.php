<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: /');
}
?>
<!doctype html>
<html lang="ru">
<head>
    <?php require_once __DIR__ . "/components/head.php"?>
    <title>Вход</title>
</head>
<body>
<?php
require_once __DIR__ . "/components/header.php"
?>
<section class="main">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Авторизация</h3>
            </div>
            <div class="card-body">
                <?php
                if (isset($_SESSION['message'])) {
                ?>
                    <div class="alert <?= ($_SESSION['messageType'] == 'danger') ? 'alert-danger' : 'alert-success' ?> text-center" role="alert">
                        <?= $_SESSION['message'] ?>
                    </div>
                <?php
                    if (isset($_SESSION['fields'])) {
                        $fields = $_SESSION['fields'];
                        unset($_SESSION['fields']);
                    }
                    unset($_SESSION['message']);
                }
                ?>
                <form method="post" action="/actions/user/login.php">
                    <div class="mb-3">
                        <label for="emailField" class="form-label">E-mail</label>
                        <input
                                type="text"
                                name="email"
                                value="<?= $fields['email']['value'] ?? '' ?>"
                                class="form-control <?= $fields['email']['error'] ? 'is-invalid' : '' ?> <?= empty($fields['email']['value']) ? '' : 'is-valid' ?>"
                                id="emailField">
                        <div class="invalid-feedback"><?= $fields['email']['message'] ?? '' ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="passwordField" class="form-label">Пароль</label>
                        <input
                                type="password"
                                name="password"
                                value="<?= $fields['password']['value'] ?? '' ?>"
                                class="form-control <?= $fields['password']['error'] ? 'is-invalid' : '' ?> <?= empty($fields['password']['value']) ? '' : 'is-valid' ?>"
                                id="passwordField">
                        <div class="invalid-feedback"><?= $fields['password']['message'] ?? '' ?></div>
                    </div>
                    <button type="submit" class="btn btn-dark">Войти</button>
                </form>
            </div>
        </div>
    </div>
</section>
<?php require_once __DIR__ . "/components/scripts.php"?>
</body>
</html>