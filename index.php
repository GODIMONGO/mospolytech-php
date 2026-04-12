<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello, World! — Макурин</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: #f5f5f5;
            color: #333;
        }

        header {
            background: #fff;
            border-bottom: 2px solid #222;
            padding: 15px 30px;
            display: flex;
            align-items: center;
        }

        header img {
            height: 50px;
        }

        header h1 {
            flex: 1;
            text-align: center;
            font-size: 20px;
            font-weight: 600;
        }

        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .content {
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-align: center;
        }

        .content h2 {
            font-size: 28px;
            margin-bottom: 15px;
        }

        .content p {
            font-size: 16px;
            color: #666;
        }

        footer {
            background: #222;
            color: #aaa;
            text-align: center;
            padding: 15px 30px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<header>
    <img src="Logo_Polytech_rus_main.jpg" alt="Московский Политех">
    <h1>Домашняя работа: Hello, World!</h1>
</header>

<main>
    <div class="content">
        <?php
            $hour = (int) date('G');
            if ($hour >= 6 && $hour < 12) {
                $greeting = 'Доброе утро';
            } elseif ($hour >= 12 && $hour < 18) {
                $greeting = 'Добрый день';
            } elseif ($hour >= 18 && $hour < 23) {
                $greeting = 'Добрый вечер';
            } else {
                $greeting = 'Доброй ночи';
            }
        ?>
        <h2><?= $greeting ?>, World!</h2>
        <p>Сейчас серверное время: <?= date('H:i:s, d.m.Y') ?></p>
    </div>
</main>

<footer>
    Задание для самостоятельной работы &laquo;Hello, World!&raquo; &mdash; Макурин
</footer>

</body>
</html>