<?php
/**
 * Контроллер раздела "Статьи".
 *
 * Обрабатывает все операции со статьями:
 *   - index() — список всех статей.
 *   - show()  — карточка одной статьи с автором и комментариями.
 *   - edit()  — форма редактирования (GET) и сохранение изменений (POST).
 *
 * Контроллер работает напрямую с БД через PDO, потому что выделять
 * отдельный слой моделей для учебного проекта избыточно. Для боевого
 * проекта стоило бы вынести SQL в классы-модели (например, ArticleRepository).
 */

namespace Controllers;

use Database;

class ArticlesController
{
    /**
     * GET /articles — список всех статей в обратном хронологическом порядке.
     */
    public function index(): void
    {
        $db = Database::getConnection();

        // Сразу подтягиваем nickname автора через JOIN —
        // одним запросом вместо N+1.
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

    /**
     * GET /articles/{id} — страница одной статьи.
     *
     * Делает три отдельных запроса:
     *   1. Сама статья по id.
     *   2. Автор статьи (для блока "Автор:").
     *   3. Все комментарии к статье (вместе с никами их авторов).
     */
    public function show(int $id): void
    {
        $db = Database::getConnection();

        // --- Запрос 1: статья ---
        // prepare + execute — защита от SQL-инъекций: значение $id
        // подставится как параметр, а не склеится со строкой запроса.
        $stmt = $db->prepare('SELECT * FROM articles WHERE id = ?');
        $stmt->execute([$id]);
        $article = $stmt->fetch();

        // Если статьи с таким id нет — отдаём 404 и выходим.
        if (!$article) {
            http_response_code(404);
            echo '404 — статья не найдена';
            return;
        }

        // --- Запрос 2: автор статьи ---
        $stmt = $db->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$article['user_id']]);
        $author = $stmt->fetch();

        // --- Запрос 3: комментарии к статье + ники их авторов ---
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

    /**
     * GET  /articles/{id}/edit — показать форму с текущими данными статьи.
     * POST /articles/{id}/edit — сохранить новые значения и редиректнуть
     *                            на страницу статьи.
     */
    public function edit(int $id): void
    {
        $db = Database::getConnection();

        // Сначала проверяем, что такая статья вообще есть.
        $stmt = $db->prepare('SELECT * FROM articles WHERE id = ?');
        $stmt->execute([$id]);
        $article = $stmt->fetch();

        if (!$article) {
            http_response_code(404);
            echo '404 — статья не найдена';
            return;
        }

        // POST — пользователь нажал "Сохранить".
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // trim убирает случайные пробелы по краям.
            // ?? '' — на случай, если поле вообще не пришло.
            $stmt = $db->prepare('UPDATE articles SET title = ?, text = ? WHERE id = ?');
            $stmt->execute([
                trim($_POST['title'] ?? ''),
                trim($_POST['text']  ?? ''),
                $id,
            ]);

            // PRG-паттерн (Post-Redirect-Get): после POST делаем редирект,
            // чтобы обновление страницы не отправляло форму повторно.
            // SCRIPT_NAME — путь до index.php на сервере, нужен чтобы
            // ссылка работала и в корне, и в подпапке /Makurin/kurs/.
            header('Location: ' . $_SERVER['SCRIPT_NAME'] . '/articles/' . $id);
            exit;
        }

        // GET — просто показываем форму, предзаполненную текущими данными.
        render('articles/edit', [
            'title'   => 'Редактирование: ' . $article['title'],
            'article' => $article,
        ]);
    }
}
