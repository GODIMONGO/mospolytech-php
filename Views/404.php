<?php /** Страница 404 — подключается из index.php, если маршрут не найден. */ ?>

<div style="text-align:center; padding: 100px 0;" class="reveal visible">
    <h1 style="font-size:7em; font-weight:800; background:var(--gradient); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; line-height:1;">404</h1>
    <p style="color:var(--text-dim); font-size:1.2em; margin:20px 0 32px;">Такой страницы не существует</p>
    <a href="<?= $_SERVER['SCRIPT_NAME'] ?>/" class="btn">← На главную</a>
</div>
