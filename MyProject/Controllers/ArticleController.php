<?php

namespace MyProject\Controllers;

use Database;

class ArticleController
{
    public function edit(int $id): void
    {
        $db = Database::getConnection();

        // Получаем статью по ID для заполнения формы текущими данными
        $stmt = $db->prepare('SELECT * FROM articles WHERE id = ?');
        $stmt->execute([$id]);
        $article = $stmt->fetch();

        if (!$article) {
            http_response_code(404);
            echo '404 — статья не найдена';
            return;
        }

        // Если пришёл POST — сохраняем изменения в БД
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $text  = $_POST['text']  ?? '';

            $stmt = $db->prepare('UPDATE articles SET title = ?, text = ? WHERE id = ?');
            $stmt->execute([$title, $text, $id]);

            // Перенаправляем на страницу статьи после сохранения
            // SCRIPT_NAME содержит полный путь до index.php на сервере
            header('Location: ' . $_SERVER['SCRIPT_NAME'] . '/articles/' . $id);
            exit;
        }

        // GET — показываем форму редактирования
        render('articles/edit', [
            'title'   => 'Редактирование статьи',
            'article' => $article,
        ]);
    }
}
