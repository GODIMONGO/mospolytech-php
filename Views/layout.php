<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'IT-блог') ?></title>
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

<main>
    <?= $content ?>
</main>

<footer>
    <p>IT-блог © <?= date('Y') ?> — MVC на чистом PHP</p>
</footer>

</body>
</html>
