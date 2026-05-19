<?php

require_once 'Database.php';

$db = Database::getConnection();

$db->exec("
    CREATE TABLE IF NOT EXISTS users (
        id       INTEGER PRIMARY KEY AUTOINCREMENT,
        nickname TEXT NOT NULL
    )
");

$db->exec("
    CREATE TABLE IF NOT EXISTS articles (
        id         INTEGER PRIMARY KEY AUTOINCREMENT,
        title      TEXT NOT NULL,
        text       TEXT NOT NULL,
        user_id    INTEGER NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )
");

$db->exec("
    CREATE TABLE IF NOT EXISTS comments (
        id         INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id    INTEGER NOT NULL,
        article_id INTEGER NOT NULL,
        text       TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id)    REFERENCES users(id),
        FOREIGN KEY (article_id) REFERENCES articles(id)
    )
");

if ($db->query('SELECT COUNT(*) FROM users')->fetchColumn() == 0) {
    $db->exec("INSERT INTO users (nickname) VALUES ('dmitry_dev'), ('anna_coder'), ('max_php')");
    $db->exec("
        INSERT INTO articles (title, text, user_id) VALUES
        ('Введение в PHP MVC', 'MVC (Model-View-Controller) — архитектурный паттерн, разделяющий логику приложения, данные и отображение. В этой статье разберём как реализовать простой MVC-фреймворк на PHP с нуля.', 1),
        ('Рекурсия в программировании', 'Рекурсия — это когда функция вызывает саму себя. Классический пример — факториал числа: 5! = 5 * 4! = 5 * 4 * 3! ... Рекурсивные алгоритмы элегантны, но требуют внимания к базовому случаю.', 1),
        ('ООП в PHP: основные принципы', 'Объектно-ориентированное программирование строится на четырёх принципах: инкапсуляция, наследование, полиморфизм и абстракция. PHP поддерживает все эти концепции начиная с версии 5.', 2),
        ('PDO и работа с базами данных', 'PDO (PHP Data Objects) — расширение для работы с БД через единый интерфейс. Поддерживает MySQL, SQLite, PostgreSQL и другие СУБД. Главное преимущество — защита от SQL-инъекций через prepared statements.', 3)
    ");
    $db->exec("
        INSERT INTO comments (user_id, article_id, text) VALUES
        (2, 1, 'Отличная статья, всё понятно объяснено!'),
        (3, 1, 'А как быть с производительностью MVC на больших проектах?'),
        (1, 2, 'Рекурсия — мощный инструмент, главное не забыть про условие выхода.')
    ");
}

echo 'Готово. Таблицы созданы, данные добавлены.';
