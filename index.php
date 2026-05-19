<?php

// Автозагрузка классов по PSR-4: имя класса -> путь к файлу
spl_autoload_register(function (string $className) {
    require_once __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';
});

// Рендерит шаблон через layout.php
function render(string $view, array $vars = []): void
{
    extract($vars);
    ob_start();
    include __DIR__ . '/Views/' . $view . '.php';
    $content = ob_get_clean();
    include __DIR__ . '/Views/layout.php';
}

// Получаем URI, убирая базовый путь сервера (/Makurin/kurs/index.php)
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$uri = preg_replace('~^.*?/index\.php~', '', $uri);
$uri = trim($uri, '/');

// Таблица маршрутов: шаблон => [Контроллер, метод]
$routes = [
    '~^$~'                          => [\Controllers\HomeController::class,     'index'],
    '~^calculator$~'                => [\Controllers\HomeController::class,     'calculator'],
    '~^articles$~'                  => [\Controllers\ArticlesController::class,  'index'],
    '~^articles/(\d+)$~'            => [\Controllers\ArticlesController::class,  'show'],
    '~^articles/(\d+)/edit$~'       => [\Controllers\ArticlesController::class,  'edit'],
    '~^articles/(\d+)/comments$~'   => [\Controllers\CommentsController::class,  'add'],
    '~^comments/(\d+)/edit$~'       => [\Controllers\CommentsController::class,  'edit'],
];

$matched = false;
foreach ($routes as $pattern => $handler) {
    if (preg_match($pattern, $uri, $matches)) {
        [$class, $method] = $handler;
        $param = $matches[1] ?? null;
        $param !== null
            ? (new $class())->$method((int) $param)
            : (new $class())->$method();
        $matched = true;
        break;
    }
}

if (!$matched) {
    http_response_code(404);
    render('404', ['title' => '404 — Страница не найдена']);
}
