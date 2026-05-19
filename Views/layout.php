<?php /**
 * Общий каркас всех страниц.
 * Подключает шрифты Google Fonts, иконку лого через SVG-градиент
 * и подгружает app.js для интерактивных анимаций.
 */ ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'DevHub — IT-блог') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $_SERVER['SCRIPT_NAME'] ?>/../style.css">
</head>
<body>

<!-- SVG-градиент для логотипа (не отображается, используется для fill: url) -->
<svg width="0" height="0" style="position:absolute">
    <defs>
        <linearGradient id="logo-gradient" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#8b5cf6"/>
            <stop offset="100%" stop-color="#ec4899"/>
        </linearGradient>
    </defs>
</svg>

<header>
    <div class="header-inner">
        <a href="<?= $_SERVER['SCRIPT_NAME'] ?>/" class="logo">
            <svg width="28" height="28" viewBox="0 0 24 24">
                <path d="M8 2 L2 12 L8 22 M16 2 L22 12 L16 22 M14 4 L10 20" stroke="url(#logo-gradient)" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>DevHub</span>
        </a>
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
    <p>DevHub © <?= date('Y') ?> · Made with <span class="heart">♥</span> on PHP</p>
    <p>MVC-фреймворк собственной разработки · SQLite · PSR-4 autoloading</p>
</footer>

<script src="<?= $_SERVER['SCRIPT_NAME'] ?>/../app.js"></script>
</body>
</html>
