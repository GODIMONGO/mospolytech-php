<?php

namespace Controllers;

use Database;

class ArticlesController
{
    public function show(int $id): void
    {
        $db = Database::getConnection();

        // Запрос 1: получаем статью по ID
        $stmt = $db->prepare('SELECT * FROM articles WHERE id = ?');
        $stmt->execute([$id]);
        $article = $stmt->fetch();

        if (!$article) {
            http_response_code(404);
            echo '404 — статья не найдена';
            return;
        }

        // Запрос 2: получаем автора статьи из таблицы users
        $stmt = $db->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$article['user_id']]);
        $author = $stmt->fetch();

        render('articles/show', [
            'title'   => $article['title'],
            'article' => $article,
            'author'  => $author,
        ]);
    }
}
