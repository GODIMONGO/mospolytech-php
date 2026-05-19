<?php /**
 * Страница 404 — показывается, если ни один маршрут не подошёл.
 * Подключается из index.php при $matched === false.
 */ ?>

<div style="text-align:center; padding: 60px 0;">
    <h1 style="font-size:4em; color:#cbd5e1;">404</h1>
    <p>Страница не найдена.</p>
    <a href="<?= $_SERVER['SCRIPT_NAME'] ?>/" class="btn" style="margin-top:20px; display:inline-block;">На главную</a>
</div>
