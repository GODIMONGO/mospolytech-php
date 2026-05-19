<?php /**
 * Страница калькулятора.
 * $expression — текст из формы, $result — результат или null, $error — ошибка или null.
 */ ?>

<div class="calc-hero reveal visible">
    <h1>Калькулятор</h1>
    <p>Рекурсивный парсер математических выражений</p>
</div>

<form method="post" class="calc-form">
    <input type="text"
           name="expression"
           value="<?= htmlspecialchars($expression) ?>"
           placeholder="2^10 + sqrt(144) - 5!"
           autofocus>
    <button type="submit">Вычислить</button>
</form>

<?php if ($result !== null): ?>
    <div class="calc-result">
        <span class="expr"><?= htmlspecialchars($expression) ?></span>
        <span class="eq">=</span>
        <span class="val"><?= htmlspecialchars($result) ?></span>
    </div>
<?php elseif ($error !== null): ?>
    <div class="calc-error">⚠ Ошибка: <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="calc-examples reveal">
    <h3>Поддерживаемые операции</h3>
    <ul>
        <li><code>2^10</code> — возведение в степень</li>
        <li><code>5!</code> — факториал</li>
        <li><code>sqrt(144)</code> — квадратный корень</li>
        <li><code>ln(e)</code> — натуральный логарифм</li>
        <li><code>log(1000)</code> — десятичный логарифм</li>
        <li><code>(2+3)*4 - 1</code> — скобки и приоритеты</li>
        <li><code>pi * 5^2</code> — площадь круга r=5</li>
        <li><code>-3^2 + 10</code> — унарный минус</li>
    </ul>
</div>
