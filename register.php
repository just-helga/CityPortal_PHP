<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: /');
    die();
}
?>
<!doctype html>
<html lang="ru">
<head>
    <?php require_once __DIR__ . "/components/head.php"?>
    <title>Регистрация</title>
</head>
<body>
<?php
require_once __DIR__ . "/components/header.php";
?>
<section class="main">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Регистрация</h3>
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
                <form method="post" action="/actions/user/register.php">
                    <div class="mb-3">
                        <label for="emailRegisterField" class="form-label">E-mail</label>
                        <input
                                type="text"
                                name="email"
                                value="<?= $fields['email']['value'] ?? '' ?>"
                                class="form-control <?= $fields['email']['error'] ? 'is-invalid' : '' ?> <?= empty($fields['email']['value']) ? '' : 'is-valid' ?>"
                                id="emailRegisterField">
                        <div class="invalid-feedback"><?= $fields['email']['message'] ?? '' ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="fullNameField" class="form-label">ФИО</label>
                        <input
                                type="text"
                                name="name"
                                value="<?= $fields['name']['value'] ?? '' ?>"
                                class="form-control <?= $fields['name']['error'] ? 'is-invalid' : '' ?> <?= empty($fields['name']['value']) ? '' : 'is-valid' ?>"
                                id="fullNameField">
                        <div class="invalid-feedback"><?= $fields['name']['message'] ?? '' ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="dobField" class="form-label">Дата рождения</label>
                        <input
                                type="date"
                                name="dob"
                                value="<?= $fields['dob']['value'] ?? '' ?>"
                                class="form-control <?= $fields['dob']['error'] ? 'is-invalid' : '' ?> <?= empty($fields['dob']['value']) ? '' : 'is-valid' ?>"
                                id="dobField">
                        <div class="invalid-feedback"><?= $fields['dob']['message'] ?? '' ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="passwordRegisterField" class="form-label">Пароль</label>
                        <input
                                type="password"
                                name="password"
                                value="<?= $fields['password']['value'] ?? '' ?>"
                                class="form-control <?= $fields['password']['error'] ? 'is-invalid' : '' ?> <?= empty($fields['password']['value']) ? '' : 'is-valid' ?>"
                                id="passwordRegisterField">
                        <div class="invalid-feedback"><?= $fields['password']['message'] ?? '' ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="passwordConfirmField" class="form-label">Подтверждение пароля</label>
                        <input
                                type="password"
                                name="password_confirmation"
                                value="<?= $fields['confirm']['value'] ?? '' ?>"
                                class="form-control <?= $fields['password']['error'] ? 'is-invalid' : '' ?> <?= empty($fields['password']['value']) ? '' : 'is-valid' ?>"
                                id="passwordConfirmField">
                        <div class="invalid-feedback"><?= $fields['password']['message'] ?? '' ?></div>
                    </div>
                    <button type="submit" class="btn btn-dark">Создать аккаунт</button>
                </form>
                <?php
                        unset($fields);
                ?>
            </div>
        </div>
    </div>
</section>
<?php require_once __DIR__ . "/components/scripts.php"?>
</body>
</html>