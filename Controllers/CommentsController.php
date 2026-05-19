<?php
/**
 * Контроллер комментариев.
 *
 * Обрабатывает добавление и редактирование комментариев к статьям.
 * Сам список комментариев показывается на странице статьи
 * (ArticlesController::show), поэтому отдельного метода index() здесь нет.
 *
 * Авторизация в проекте не реализована, поэтому при добавлении
 * комментария user_id жёстко равен 1 (первый пользователь). В реальном
 * приложении сюда бы пришёл id из сессии.
 */

namespace Controllers;

use Database;

class CommentsController
{
    /**
     * POST /articles/{articleId}/comments — добавить комментарий.
     *
     * После успешного добавления делает редирект на страницу статьи
     * с якорем на свежедобавленный комментарий (#commentN), чтобы
     * пользователь сразу увидел свой комментарий.
     */
    public function add(int $articleId): void
    {
        $text = trim($_POST['text'] ?? '');

        // Если текст не пустой — добавляем комментарий в БД.
        if ($text !== '') {
            $db = Database::getConnection();

            $stmt = $db->prepare(
                'INSERT INTO comments (user_id, article_id, text) VALUES (?, ?, ?)'
            );
            // user_id=1 — заглушка, поскольку авторизация ещё не сделана.
            $stmt->execute([1, $articleId, $text]);

            // Узнаём id только что вставленной строки, чтобы поставить
            // на неё якорь в URL.
            $commentId = $db->lastInsertId();

            header(
                'Location: ' . $_SERVER['SCRIPT_NAME']
                . '/articles/' . $articleId
                . '#comment' . $commentId
            );
            exit;
        }

        // Пустой комментарий — просто возвращаем на статью без сохранения.
        header('Location: ' . $_SERVER['SCRIPT_NAME'] . '/articles/' . $articleId);
        exit;
    }

    /**
     * GET  /comments/{id}/edit — показать форму редактирования комментария.
     * POST /comments/{id}/edit — сохранить новый текст и вернуться к статье.
     */
    public function edit(int $id): void
    {
        $db = Database::getConnection();

        // Сначала находим комментарий — заодно узнаём article_id,
        // чтобы корректно отредиректить после сохранения.
        $stmt = $db->prepare('SELECT * FROM comments WHERE id = ?');
        $stmt->execute([$id]);
        $comment = $stmt->fetch();

        if (!$comment) {
            http_response_code(404);
            echo '404 — комментарий не найден';
            return;
        }

        // Обработка отправки формы (POST).
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $text = trim($_POST['text'] ?? '');

            $stmt = $db->prepare('UPDATE comments SET text = ? WHERE id = ?');
            $stmt->execute([$text, $id]);

            // PRG: после сохранения уводим на статью с якорем на этот комментарий.
            header(
                'Location: ' . $_SERVER['SCRIPT_NAME']
                . '/articles/' . $comment['article_id']
                . '#comment' . $id
            );
            exit;
        }

        // GET — отдаём форму с текущим текстом комментария.
        render('comments/edit', [
            'title'   => 'Редактирование комментария',
            'comment' => $comment,
        ]);
    }
}
