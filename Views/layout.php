<?php /**
 * Общий каркас всех страниц сайта.
 * В него подставляются переменные $title и $content, заполняемые
 * функцией render() в index.php.
 */ ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <!-- htmlspecialchars защищает от XSS, если в title попадёт пользовательский ввод -->
    <title><?= htmlspecialchars($title ?? 'IT-блог') ?></title>
    <!-- Подключаем style.css относительно корня сайта (как и index.php) -->
    <link rel="stylesheet" href="<?= $_SERVER['SCRIPT_NAME'] ?>/../style.css">
</head>
<body>

<header>
    <div class="header-inner">
        <a href="<?= $_SERVER['SCRIPT_NAME'] ?>/" class="logo">IT-блог</a>
        <nav>
            <a href="<?= $_SERVER['SCRIPT_NAME'] ?>/">Главная</a>
            <a href="<?= $_SERVER['SCRIPT_NAME'] ?>/articles">Статьи</a>
            <a href="<?= $_SERVER['SCRIPT_NAME'] ?>/calculator">Калькулятор</a>
        </nav>
    </div>
</header>

<!-- Сюда render() подставит результат конкретного шаблона -->
<main>
    <?= $content ?>
</main>

<footer>
    <p>IT-блог © <?= date('Y') ?> — MVC на чистом PHP</p>
</footer>

</body>
</html>
