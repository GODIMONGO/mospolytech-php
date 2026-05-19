<?php

namespace Controllers;

use Database;

class ArticlesController
{
    // Список всех статей
    public function index(): void
    {
        $db   = Database::getConnection();
        $stmt = $db->query('
            SELECT articles.*, users.nickname AS author_nickname
            FROM articles
            JOIN users ON users.id = articles.user_id
            ORDER BY articles.created_at DESC
        ');
        $articles = $stmt->fetchAll();

        render('articles/index', [
            'title'    => 'Статьи',
            'articles' => $articles,
        ]);
    }

    // Страница статьи с комментариями
    public function show(int $id): void
    {
        $db = Database::getConnection();

        // Запрос 1: статья
        $stmt = $db->prepare('SELECT * FROM articles WHERE id = ?');
        $stmt->execute([$id]);
        $article = $stmt->fetch();

        if (!$article) {
            http_response_code(404);
            echo '404 — статья не найдена';
            return;
        }

        // Запрос 2: автор статьи
        $stmt = $db->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$article['user_id']]);
        $author = $stmt->fetch();

        // Запрос 3: комментарии со своими авторами
        $stmt = $db->prepare('
            SELECT comments.*, users.nickname AS author_nickname
            FROM comments
            JOIN users ON users.id = comments.user_id
            WHERE comments.article_id = ?
            ORDER BY comments.created_at ASC
        ');
        $stmt->execute([$id]);
        $comments = $stmt->fetchAll();

        render('articles/show', [
            'title'    => $article['title'],
            'article'  => $article,
            'author'   => $author,
            'comments' => $comments,
        ]);
    }

    // Редактирование статьи
    public function edit(int $id): void
    {
        $db   = Database::getConnection();
        $stmt = $db->prepare('SELECT * FROM articles WHERE id = ?');
        $stmt->execute([$id]);
        $article = $stmt->fetch();

        if (!$article) {
            http_response_code(404);
            echo '404 — статья не найдена';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $stmt = $db->prepare('UPDATE articles SET title = ?, text = ? WHERE id = ?');
            $stmt->execute([
                trim($_POST['title'] ?? ''),
                trim($_POST['text']  ?? ''),
                $id,
            ]);
            header('Location: ' . $_SERVER['SCRIPT_NAME'] . '/articles/' . $id);
            exit;
        }

        render('articles/edit', [
            'title'   => 'Редактирование: ' . $article['title'],
            'article' => $article,
        ]);
    }
}
