<?php

namespace Controllers;

use Database;
use Calculator;

class HomeController
{
    // Главная страница — последние 3 статьи
    public function index(): void
    {
        $db   = Database::getConnection();
        $stmt = $db->query('
            SELECT articles.*, users.nickname AS author_nickname
            FROM articles
            JOIN users ON users.id = articles.user_id
            ORDER BY articles.created_at DESC
            LIMIT 3
        ');
        $articles = $stmt->fetchAll();

        render('home/index', [
            'title'    => 'IT-блог — Главная',
            'articles' => $articles,
        ]);
    }

    // Страница калькулятора — GET показывает форму, POST вычисляет
    public function calculator(): void
    {
        $expression = '';
        $result     = null;
        $error      = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $expression = trim($_POST['expression'] ?? '');
            try {
                $result = (new Calculator())->evaluate($expression);
            } catch (Throwable $e) {
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
