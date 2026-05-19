<?php

namespace Controllers;

use Database;

class CommentsController
{
    // POST /articles/123/comments — добавить комментарий к статье
    public function add(int $articleId): void
    {
        $text = trim($_POST['text'] ?? '');

        if ($text !== '') {
            $db   = Database::getConnection();
            $stmt = $db->prepare(
                'INSERT INTO comments (user_id, article_id, text) VALUES (?, ?, ?)'
            );
            // user_id=1 — заглушка, т.к. авторизации ещё нет
            $stmt->execute([1, $articleId, $text]);
            $commentId = $db->lastInsertId();

            // Редирект на страницу статьи с якорем на новый комментарий
            header('Location: ' . $_SERVER['SCRIPT_NAME'] . '/articles/' . $articleId . '#comment' . $commentId);
            exit;
        }

        // Если текст пустой — возвращаем на статью без якоря
        header('Location: ' . $_SERVER['SCRIPT_NAME'] . '/articles/' . $articleId);
        exit;
    }

    // GET  /comments/456/edit — показать форму редактирования
    // POST /comments/456/edit — сохранить изменения
    public function edit(int $id): void
    {
        $db   = Database::getConnection();
        $stmt = $db->prepare('SELECT * FROM comments WHERE id = ?');
        $stmt->execute([$id]);
        $comment = $stmt->fetch();

        if (!$comment) {
            http_response_code(404);
            echo '404 — комментарий не найден';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $text = trim($_POST['text'] ?? '');

            $stmt = $db->prepare('UPDATE comments SET text = ? WHERE id = ?');
            $stmt->execute([$text, $id]);

            // После сохранения — возвращаем на статью с якорем
            header('Location: ' . $_SERVER['SCRIPT_NAME'] . '/articles/' . $comment['article_id'] . '#comment' . $id);
            exit;
        }

        render('comments/edit', [
            'title'   => 'Редактирование комментария',
            'comment' => $comment,
        ]);
    }
}
