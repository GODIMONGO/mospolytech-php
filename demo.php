<?php

require_once 'encapsulation.php';
require_once 'inheritance.php';
require_once 'interfaces.php';
require_once 'abstract.php';

// Инкапсуляция
$cat1 = new Cat('Мурка', 'рыжая');
$cat2 = new Cat('Снежок', 'белая');

// Наследование
$lesson = new PaidLesson('Урок о наследовании в PHP', 'Лол, кек, чебурек', 'Ложитесь спать', 99.90);

// Интерфейсы
$circle    = new Circle(5);
$rectangle = new Rectangle(4, 6);
$triangle  = new Triangle(3, 8);

// Абстрактные классы
$russian = new RussianHuman('Иван');
$english = new EnglishHuman('John');

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Лабораторная 6 — ООП в PHP</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 30px; }
        h1 { color: #333; }
        .block { background: #fff; border-left: 4px solid #4a90d9; padding: 16px 20px; margin-bottom: 20px; border-radius: 4px; box-shadow: 0 1px 4px rgba(0,0,0,.1); }
        .block h2 { margin: 0 0 12px; color: #4a90d9; font-size: 1.1em; }
        .block p { margin: 4px 0; color: #444; }
        .label { color: #888; font-size: .85em; }
    </style>
</head>
<body>

<h1>Лабораторная работа 6 — ООП в PHP</h1>

<div class="block">
    <h2>1. Инкапсуляция — класс Cat</h2>
    <p><?= $cat1->sayHello() ?></p>
    <p><?= $cat2->sayHello() ?></p>
    <p class="label">Цвет Мурки через геттер: <?= $cat1->getColor() ?></p>
</div>

<div class="block">
    <h2>2. Наследование — классы Lesson / PaidLesson</h2>
    <p><b><?= $lesson->getTitle() ?></b></p>
    <p><?= $lesson->getText() ?></p>
    <p class="label">ДЗ: <?= $lesson->getHomework() ?></p>
    <p class="label">Цена: <?= $lesson->getPrice() ?> руб.</p>
</div>

<div class="block">
    <h2>3. Интерфейсы — CalculateSquare</h2>
    <?php
    foreach ([$circle, $rectangle, $triangle] as $obj) {
        $name = get_class($obj);
        if ($obj instanceof CalculateSquare) {
            echo "<p>$name — площадь: " . round($obj->calculateSquare(), 2) . "</p>";
        } else {
            echo "<p class='label'>$name — не реализует CalculateSquare</p>";
        }
    }
    ?>
</div>

<div class="block">
    <h2>4. Абстрактные классы — RussianHuman / EnglishHuman</h2>
    <p><?= $russian->introduceYourself() ?></p>
    <p><?= $english->introduceYourself() ?></p>
</div>

</body>
</html>
