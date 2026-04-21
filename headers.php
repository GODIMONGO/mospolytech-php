<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>get_headers — Макурин</title>
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
            padding: 40px 20px;
        }

        .content {
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 700px;
        }

        .content h2 {
            margin-bottom: 16px;
            font-size: 20px;
            text-align: center;
        }

        .url-info {
            font-size: 13px;
            color: #666;
            margin-bottom: 12px;
            text-align: center;
        }

        textarea {
            width: 100%;
            height: 300px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-family: monospace;
            font-size: 13px;
            resize: vertical;
            background: #fafafa;
            margin-bottom: 20px;
        }

        .back-link {
            display: block;
            text-align: center;
            color: #555;
            font-size: 14px;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
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
    <img src="Logo_Polytech_rus_main(1).jpg" alt="Московский Политех">
    <h1>Самостоятельная работа: Feedback form</h1>
</header>

<main>
    <div class="content">
        <h2>Результат get_headers</h2>

        <?php
            $url = 'https://httpbin.org/post';
            $headers = get_headers($url);
            $output = implode("\n", $headers);
        ?>

        <p class="url-info">URL: <?= htmlspecialchars($url) ?></p>

        <textarea readonly><?= htmlspecialchars($output) ?></textarea>

        <a class="back-link" href="feedback.php">← Вернуться к форме</a>
    </div>
</main>

<footer>
    Задание для самостоятельной работы &laquo;Feedback form&raquo;
</footer>

</body>
</html>
