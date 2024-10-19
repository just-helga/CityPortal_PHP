<?php session_start(); ?>
<!doctype html>
<html lang="ru">
<head>
    <?php
    require_once __DIR__ . "/components/head.php";
    $config = require_once __DIR__ . "/config/app.php";
    if (isset($_SESSION['user'])) {
        if ($user['role_id'] !== $config['admin_role']) {
            header('Location: /');
            die();
        }
    } else {
        header('Location: /login.php');
        die();
    }
    ?>
    <title>Управление заявками</title>
</head>
<body>
<?php require_once __DIR__ . "/components/header.php"?>
<section class="main">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Управление заявками</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Изображение</th>
                        <th scope="col">Название</th>
                        <th scope="col">Описание</th>
                        <th scope="col">Статус</th>
                        <th scope="col">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $tickets = $db->query("SELECT tickets.*, tags.label, tags.bg_color, tags.text_color FROM tickets INNER JOIN tags ON tickets.tag_id = tags.id")->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($tickets as $ticket) {
                    ?>
                    <tr>
                        <td>
                            <img src="<?= $ticket['image'] ?>" width="200" alt="">
                        </td>
                        <td><?= $ticket['title'] ?></td>
                        <td><?= $ticket['description'] ?></td>
                        <td>
                            <span class="btn" style="width: 110px; cursor: auto;background-color: <?= $ticket['bg_color'] ?>; color: <?= $ticket['text_color'] ?>"><?= $ticket['label'] ?></span>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Действия
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <form action="/actions/ticket/change_tag.php" method="post">
                                            <input type="hidden" value="<?= $ticket['id'] ?>" name="id">
                                            <input type="hidden" value="<?= $config['complet_tag'] ?>" name="tag">
                                            <input type="hidden" value="<?= $user['role_id'] ?>" name="user_role">
                                            <button class="dropdown-item" type="submit">Выполнено</button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="/actions/ticket/change_tag.php" method="post">
                                            <input type="hidden" value="<?= $ticket['id'] ?>" name="id">
                                            <input type="hidden" value="<?= $config['in_process_tag'] ?>" name="tag">
                                            <input type="hidden" value="<?= $user['role_id'] ?>" name="user_role">
                                            <button class="dropdown-item" type="submit">В процессе</button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="/actions/ticket/change_tag.php" method="post">
                                            <input type="hidden" value="<?= $ticket['id'] ?>" name="id">
                                            <input type="hidden" value="<?= $config['reject_tag'] ?>" name="tag">
                                            <input type="hidden" value="<?= $user['role_id'] ?>" name="user_role">
                                            <button class="dropdown-item" type="submit">Отклонить</button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="/actions/ticket/remove.php" method="post">
                                            <input type="hidden" value="<?= $ticket['id'] ?>" name="id">
                                            <input type="hidden" value="<?= $user['role_id'] ?>" name="user_role">
                                            <button class="dropdown-item" type="submit">Удалить</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?php require_once __DIR__ . "/components/scripts.php"?>
</body>
</html>