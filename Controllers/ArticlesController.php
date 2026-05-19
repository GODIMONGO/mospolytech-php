<?php
/**
 * Контроллер раздела "Темы" форума.
 *
 *   - index() — список тем, сгруппированный по категориям (вид форума).
 *   - show()  — страница темы с автором, просмотрами и ответами.
 *   - edit()  — форма редактирования темы (GET) и сохранение (POST).
 */

namespace Controllers;

use Database;

class ArticlesController
{
    /**
     * GET /articles — все темы форума, сгруппированные по категориям.
     * Для каждой темы подтягиваем автора и количество ответов.
     */
    public function index(): void
    {
        $db = Database::getConnection();

        $stmt = $db->query('
            SELECT articles.*,
                   users.nickname AS author_nickname,
                   users.role     AS author_role,
                   (SELECT COUNT(*) FROM comments WHERE comments.article_id = articles.id) AS reply_count
            FROM articles
            JOIN users ON users.id = articles.user_id
            ORDER BY articles.category ASC, articles.created_at DESC
        ');
        $rows = $stmt->fetchAll();

        // Группируем темы по категориям для форумного вида.
        $categories = [];
        foreach ($rows as $row) {
            $categories[$row['category']][] = $row;
        }

        render('articles/index', [
            'title'      => 'Форум — все темы',
            'categories' => $categories,
            'sidebar'    => $this->sidebarData($db),
        ]);
    }

    /**
     * GET /articles/{id} — страница одной темы.
     * При каждом просмотре увеличиваем счётчик views.
     */
    public function show(int $id): void
    {
        $db = Database::getConnection();

        // Инкремент просмотров.
        $db->prepare('UPDATE articles SET views = views + 1 WHERE id = ?')->execute([$id]);

        // Запрос 1: тема.
        $stmt = $db->prepare('SELECT * FROM articles WHERE id = ?');
        $stmt->execute([$id]);
        $article = $stmt->fetch();

        if (!$article) {
            http_response_code(404);
            echo '404 — тема не найдена';
            return;
        }

        // Запрос 2: автор темы.
        $stmt = $db->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$article['user_id']]);
        $author = $stmt->fetch();

        // Запрос 3: ответы (комментарии) + их авторы.
        $stmt = $db->prepare('
            SELECT comments.*, users.nickname AS author_nickname, users.role AS author_role
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
            'sidebar'  => $this->sidebarData($db),
        ]);
    }

    /**
     * GET/POST /articles/{id}/edit — редактирование темы.
     */
    public function edit(int $id): void
    {
        $db = Database::getConnection();

        $stmt = $db->prepare('SELECT * FROM articles WHERE id = ?');
        $stmt->execute([$id]);
        $article = $stmt->fetch();

        if (!$article) {
            http_response_code(404);
            echo '404 — тема не найдена';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $stmt = $db->prepare('UPDATE articles SET title = ?, text = ? WHERE id = ?');
            $stmt->execute([
                trim($_POST['title'] ?? ''),
                trim($_POST['text']  ?? ''),
                $id,
            ]);
            // PRG: после POST редиректим на тему.
            header('Location: ' . $_SERVER['SCRIPT_NAME'] . '/articles/' . $id);
            exit;
        }

        render('articles/edit', [
            'title'   => 'Редактирование: ' . $article['title'],
            'article' => $article,
        ]);
    }

    /**
     * Данные для боковой панели: общая статистика, категории,
     * топ авторов и самые обсуждаемые темы. Используется на
     * нескольких страницах, поэтому вынесено в отдельный метод.
     */
    private function sidebarData(\PDO $db): array
    {
        return [
            'stats' => [
                'articles' => (int) $db->query('SELECT COUNT(*) FROM articles')->fetchColumn(),
                'comments' => (int) $db->query('SELECT COUNT(*) FROM comments')->fetchColumn(),
                'users'    => (int) $db->query('SELECT COUNT(*) FROM users')->fetchColumn(),
                'views'    => (int) $db->query('SELECT COALESCE(SUM(views),0) FROM articles')->fetchColumn(),
            ],
            'categories' => $db->query('
                SELECT category, COUNT(*) AS cnt
                FROM articles GROUP BY category ORDER BY cnt DESC
            ')->fetchAll(),
            'top_authors' => $db->query('
                SELECT users.nickname, users.role, COUNT(articles.id) AS cnt
                FROM users JOIN articles ON articles.user_id = users.id
                GROUP BY users.id ORDER BY cnt DESC LIMIT 5
            ')->fetchAll(),
            'hot' => $db->query('
                SELECT articles.id, articles.title,
                       (SELECT COUNT(*) FROM comments WHERE comments.article_id = articles.id) AS reply_count
                FROM articles ORDER BY reply_count DESC, views DESC LIMIT 5
            ')->fetchAll(),
        ];
    }
}
