<?php
/**
 * Контроллер главной страницы и калькулятора.
 *
 * Отвечает за две страницы сайта:
 *   - "/"           — главная: hero-блок и три последние статьи.
 *   - "/calculator" — онлайн-калькулятор математических выражений.
 *
 * Контроллер сознательно делается тонким: вся бизнес-логика
 * (например, вычисление выражения) вынесена в отдельный класс Calculator.
 */

namespace Controllers;

use Database;
use Calculator;

class HomeController
{
    /**
     * GET / — главная страница сайта.
     * Тянет из БД три самые свежие статьи и передаёт в шаблон.
     */
    public function index(): void
    {
        $db = Database::getConnection();

        // JOIN с users, чтобы сразу получить никнейм автора и не
        // делать второй запрос в цикле в шаблоне (проблема "N+1").
        $stmt = $db->query('
            SELECT articles.*, users.nickname AS author_nickname
            FROM articles
            JOIN users ON users.id = articles.user_id
            ORDER BY articles.created_at DESC
            LIMIT 3
        ');
        $articles = $stmt->fetchAll();

        // Счётчики для блока статистики на главной
        $stats = [
            'articles' => (int) $db->query('SELECT COUNT(*) FROM articles')->fetchColumn(),
            'comments' => (int) $db->query('SELECT COUNT(*) FROM comments')->fetchColumn(),
            'users'    => (int) $db->query('SELECT COUNT(*) FROM users')->fetchColumn(),
        ];

        render('home/index', [
            'title'    => 'DevHub — IT-блог о веб-разработке',
            'articles' => $articles,
            'stats'    => $stats,
        ]);
    }

    /**
     * GET  /calculator — отрисовать форму калькулятора.
     * POST /calculator — вычислить выражение и показать результат.
     *
     * Парсингом и вычислением занимается класс Calculator — здесь
     * только обработка HTTP-уровня (получить POST, поймать исключение,
     * отдать в шаблон).
     */
    public function calculator(): void
    {
        $expression = '';
        $result     = null;
        $error      = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $expression = trim($_POST['expression'] ?? '');
            try {
                // Создаём калькулятор и просим вычислить выражение.
                $result = (new Calculator())->evaluate($expression);
            } catch (\Throwable $e) {
                // Любая ошибка парсинга (деление на ноль, неверный
                // символ и т.д.) попадает сюда — показываем её
                // пользователю вместо результата.
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
