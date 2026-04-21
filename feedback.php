<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма обратной связи — Макурин</title>
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

        form {
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
        }

        form h2 {
            margin-bottom: 24px;
            font-size: 22px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            font-weight: 600;
        }

        input[type="text"],
        input[type="email"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            margin-bottom: 18px;
        }

        textarea {
            height: 100px;
            resize: vertical;
        }

        .checkbox-group {
            display: flex;
            gap: 20px;
            margin-bottom: 18px;
        }

        .checkbox-group label {
            font-weight: normal;
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }

        button[type="submit"] {
            width: 100%;
            padding: 12px;
            background: #222;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            margin-bottom: 16px;
        }

        button[type="submit"]:hover {
            background: #444;
        }

        .page-link {
            display: block;
            text-align: center;
            color: #555;
            font-size: 14px;
            text-decoration: none;
        }

        .page-link:hover {
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
    <form action="https://httpbin.org/post" method="POST">
        <h2>Форма обратной связи</h2>

        <label for="name">Имя пользователя</label>
        <input type="text" id="name" name="name" placeholder="Введите ваше имя" required>

        <label for="email">E-mail пользователя</label>
        <input type="email" id="email" name="email" placeholder="Введите ваш e-mail" required>

        <label for="type">Тип обращения</label>
        <select id="type" name="type" required>
            <option value="">— Выберите тип —</option>
            <option value="complaint">Жалоба</option>
            <option value="suggestion">Предложение</option>
            <option value="gratitude">Благодарность</option>
        </select>

        <label for="message">Текст обращения</label>
        <textarea id="message" name="message" placeholder="Введите текст обращения" required></textarea>

        <label>Вариант ответа</label>
        <div class="checkbox-group">
            <label>
                <input type="checkbox" name="reply[]" value="sms"> СМС
            </label>
            <label>
                <input type="checkbox" name="reply[]" value="email"> E-mail
            </label>
        </div>

        <button type="submit">Отправить</button>

        <a class="page-link" href="headers.php">Перейти на страницу 2 (get_headers)</a>
    </form>
</main>

<footer>
    Задание для самостоятельной работы &laquo;Feedback form&raquo;
</footer>

</body>
</html>
