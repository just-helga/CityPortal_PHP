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
    <title>Мои заявки</title>
</head>
<body>
<?php require_once __DIR__ . "/components/header.php"?>
<section class="main">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Мои заявки</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Изображение</th>
                        <th scope="col">Название</th>
                        <th scope="col">Описание</th>
                        <th scope="col">Статус</th>
                        <th scope="col text-end">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $query = $db->prepare("SELECT tickets.*, tags.label, tags.bg_color, tags.text_color FROM tickets INNER JOIN tags ON tickets.tag_id = tags.id WHERE tickets.user_id = :user_id");
                    $query->execute(['user_id' => $_SESSION['user']]);
                    $tickets = $query->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($tickets as $ticket) {
                        ?>
                        <tr>
                            <td>
                                <img src="<?= $ticket['image'] ?>" width="200" alt="">
                            </td>
                            <td><?= $ticket['title'] ?></td>
                            <td><?= $ticket['description'] ?></td>
                            <td>
                                <span class="btn w-100" style="cursor: auto;background-color: <?= $ticket['bg_color'] ?>; color: <?= $ticket['text_color'] ?>"><?= $ticket['label'] ?></span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle text-end w-100" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Действия
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <form action="/actions/ticket/remove.php" method="post">
                                                <input type="hidden" value="<?= $ticket['id'] ?>" name="id">
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