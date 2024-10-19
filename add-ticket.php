<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: /login.php');
    die();
}
?>
<!doctype html>
<html lang="ru">
<head>
    <?php require_once __DIR__ . "/components/head.php"?>
    <title>Добавить заявку</title>
</head>
<body>
<?php require_once __DIR__ . "/components/header.php"?>
<section class="main">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Новая заявка</h3>
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
                <form method="post" action="/actions/ticket/store.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="titleField" class="form-label">Тема заявки</label>
                        <input
                                type="text"
                                name="title"
                                value="<?= $fields['title']['value'] ?? '' ?>"
                                class="form-control <?= $fields['title']['error'] ? 'is-invalid' : '' ?> <?= empty($fields['title']['value']) ? '' : 'is-valid' ?>"
                                id="titleField">
                        <div class="invalid-feedback"><?= $fields['title']['message'] ?? '' ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="imageField" class="form-label">Изображение</label>
                        <input
                                type="file"
                                name="image"
                                class="form-control <?= $fields['image']['error'] ? 'is-invalid' : '' ?> <?= empty($fields['image']['value']) ? '' : 'is-valid' ?>"
                                id="imageField">
                        <div class="invalid-feedback"><?= $fields['image']['message'] ?? '' ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="descriptionField" class="form-label">Описание</label>
                        <textarea
                                name="description"
                                class="form-control <?= $fields['description']['error'] ? 'is-invalid' : '' ?> <?= empty($fields['description']['value']) ? '' : 'is-valid' ?>"
                                id="descriptionField"><?= $fields['description']['value'] ?? '' ?></textarea>
                        <div class="invalid-feedback"><?= $fields['description']['message'] ?? '' ?></div>
                    </div>
                    <button type="submit" class="btn btn-dark">Создать заявку</button>
                </form>
            </div>
        </div>
    </div>
</section>
<?php require_once __DIR__ . "/components/scripts.php"?>
</body>
</html>