<?php session_start(); ?>
<!doctype html>
<html lang="ru">
<head>
    <?php require_once __DIR__ . "/components/head.php"?>
    <title>Главная</title>
</head>
<body>
<?php require_once __DIR__ . "/components/header.php"?>
<section class="main">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Заявки</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php
                    if (isset($_GET['q'])) {
                        $q = $db->prepare("SELECT tickets.*, tags.label, tags.bg_color, tags.text_color FROM tickets INNER JOIN tags ON tickets.tag_id = tags.id WHERE `title` LIKE :q ORDER BY `id` DESC");
                        $q->execute(['q' => "%{$_GET['q']}%"]);
                        $tickets = $q->fetchAll(PDO::FETCH_ASSOC);
                    } else {
                        $tickets = $db->query("SELECT tickets.*, tags.label, tags.bg_color, tags.text_color FROM tickets INNER JOIN tags ON tickets.tag_id = tags.id ORDER BY `id` DESC")->fetchAll(PDO::FETCH_ASSOC);
                    }
                    if (empty($tickets)) {
                    ?>
                        <div class="alert alert-warning text-center" role="alert">
                            По Вашему запросу ничего не найдено
                        </div>
                    <?php
                    }
                    foreach ($tickets as $ticket) {
                        $date = date_create($ticket['created_at']);
                    ?>
                    <div class="col-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <img src="<?= $ticket['image'] ?>" class="card-img-top mb-3" alt="...">
                                <h5 class="card-title"><?= $ticket['title'] ?> <span class="badge" style="background-color: <?= $ticket['bg_color'] ?>; color: <?= $ticket['text_color'] ?>"><?= $ticket['label'] ?></span> </h5>
                                <p class="card-text"><?= $ticket['description'] ?></p>
                                <p class="card-text"><small class="text-muted">Добавлено: <?= date_format($date, 'd.m.Y') ?></small></p>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once __DIR__ . "/components/scripts.php"?>
</body>
</html>