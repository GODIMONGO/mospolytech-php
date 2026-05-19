<?php
/**
 * Контроллер главной страницы и калькулятора.
 *   - index()      — лендинг форума: hero, статистика, категории, свежие темы.
 *   - calculator() — онлайн-калькулятор математических выражений.
 */

namespace Controllers;

use Database;
use Calculator;

class HomeController
{
    /** GET / — главная страница форума. */
    public function index(): void
    {
        $db = Database::getConnection();

        // Свежие темы с автором и числом ответов.
        $latest = $db->query('
            SELECT articles.*, users.nickname AS author_nickname,
                   (SELECT COUNT(*) FROM comments WHERE comments.article_id = articles.id) AS reply_count
            FROM articles
            JOIN users ON users.id = articles.user_id
            ORDER BY articles.created_at DESC
            LIMIT 6
        ')->fetchAll();

        // Категории с количеством тем — для карточек разделов.
        $categories = $db->query('
            SELECT category, COUNT(*) AS cnt,
                   SUM(views) AS views
            FROM articles GROUP BY category ORDER BY cnt DESC
        ')->fetchAll();

        $stats = [
            'articles' => (int) $db->query('SELECT COUNT(*) FROM articles')->fetchColumn(),
            'comments' => (int) $db->query('SELECT COUNT(*) FROM comments')->fetchColumn(),
            'users'    => (int) $db->query('SELECT COUNT(*) FROM users')->fetchColumn(),
            'views'    => (int) $db->query('SELECT COALESCE(SUM(views),0) FROM articles')->fetchColumn(),
        ];

        render('home/index', [
            'title'      => 'DevHub — IT-форум сообщества',
            'latest'     => $latest,
            'categories' => $categories,
            'stats'      => $stats,
        ]);
    }

    /** GET/POST /calculator — калькулятор. Логика разбора — в классе Calculator. */
    public function calculator(): void
    {
        $expression = '';
        $result     = null;
        $error      = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $expression = trim($_POST['expression'] ?? '');
            try {
                $result = (new Calculator())->evaluate($expression);
            } catch (\Throwable $e) {
                $error = $e->getMessage();
            }
        }

        render('calculator/index', [
            'title'      => 'Калькулятор',
            'expression' => $expression,
            'result'     => $result,
            'error'      => $error,
        ]);
    }
}
