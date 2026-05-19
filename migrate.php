<?php

// Скрипт создаёт таблицы и заполняет их тестовыми данными.
// Запускать один раз: php migrate.php или открыть в браузере.

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
        id      INTEGER PRIMARY KEY AUTOINCREMENT,
        title   TEXT NOT NULL,
        text    TEXT NOT NULL,
        user_id INTEGER NOT NULL,
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

// Тестовые данные (добавляются только если таблицы пустые)
if ($db->query('SELECT COUNT(*) FROM users')->fetchColumn() == 0) {
    $db->exec("INSERT INTO users (nickname) VALUES ('ivan_dev'), ('anna_blogger')");
    $db->exec("
        INSERT INTO articles (title, text, user_id) VALUES
        ('Первая статья', 'Текст первой статьи', 1),
        ('Вторая статья', 'Текст второй статьи', 2)
    ");
}

echo 'Готово. Таблицы созданы, данные добавлены.';
