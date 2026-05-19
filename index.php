<?php
// Получаем результат и исходное выражение из GET-параметров (после расчёта на сервере).
$result = isset($_GET['result']) ? $_GET['result'] : '';
$expr   = isset($_GET['expr'])   ? $_GET['expr']   : '';
// В поле показываем результат, а если его нет — то введённое выражение.
$show   = $result !== '' ? $result : $expr;
?><!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Калькулятор</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Форма отправляет введённое выражение на сервер методом POST -->
    <form id="calc" method="post" action="calc.php">
        <!-- Поле отображения ввода и результата -->
        <input type="text" id="display" name="expression"
               value="<?= htmlspecialchars($show, ENT_QUOTES) ?>" autocomplete="off">

        <div class="keys">
            <!-- Основные кнопки: цифры, скобки, операции, точка -->
            <button type="button" data-v="(">(</button>
            <button type="button" data-v=")">)</button>
            <button type="button" data-v=".">.</button>
            <button type="button" data-v="/">÷</button>

            <button type="button" data-v="7">7</button>
            <button type="button" data-v="8">8</button>
            <button type="button" data-v="9">9</button>
            <button type="button" data-v="*">×</button>

            <button type="button" data-v="4">4</button>
            <button type="button" data-v="5">5</button>
            <button type="button" data-v="6">6</button>
            <button type="button" data-v="-">−</button>

            <button type="button" data-v="1">1</button>
            <button type="button" data-v="2">2</button>
            <button type="button" data-v="3">3</button>
            <button type="button" data-v="+">+</button>

            <button type="button" data-v="0">0</button>
            <button type="button" data-v="!">!</button>
            <button type="button" data-v="^">^</button>
            <button type="button" data-v="sqrt(">√</button>

            <!-- Дополнительные кнопки: ln, log, константы -->
            <button type="button" data-v="ln(">ln</button>
            <button type="button" data-v="log(">log</button>
            <button type="button" data-v="pi">π</button>
            <button type="button" data-v="e">e</button>

            <!-- Кнопка обнуления и кнопка расчёта -->
            <button type="button" id="clear">C</button>
            <button type="submit"  id="eq" style="grid-column: span 3;">=</button>
        </div>
    </form>

    <script src="script.js"></script>
</body>
</html>
