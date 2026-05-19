<?php

// Автозагрузка: преобразует имя класса в путь к файлу
// Например: MyProject\Controllers\ArticleController -> MyProject/Controllers/ArticleController.php
spl_autoload_register(function (string $className) {
    require_once __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';
});

// Рендерит шаблон $view, передавая переменные. $title по умолчанию — "Мой блог"
function render(string $view, array $vars = []): void
{
    extract($vars);
    ob_start();
    include __DIR__ . '/Views/' . $view . '.php';
    $content = ob_get_clean();
    include __DIR__ . '/Views/layout.php';
}

// Получаем путь из URL, убираем базовый путь и декодируем кириллицу
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$uri = preg_replace('~^/[^/]+/lab\d+/index\.php~', '', $uri); // убираем /Makurin/lab10/index.php
$uri = trim($uri, '/');

// Таблица маршрутов: регулярное выражение => [Контроллер, метод]
$routes = [
    '~^hello/(.+)$~'          => [\Controllers\HomeController::class,    'sayHello'],
    '~^bye/(.+)$~'            => [\Controllers\HomeController::class,    'sayBye'],
    '~^articles/(\d+)$~'      => [\Controllers\ArticlesController::class, 'show'],
    '~^article/(\d+)/edit$~'  => [\MyProject\Controllers\ArticleController::class, 'edit'],
];

// Перебираем маршруты и вызываем нужный метод контроллера
$matched = false;
foreach ($routes as $pattern => $handler) {
    if (preg_match($pattern, $uri, $matches)) {
        [$controllerClass, $method] = $handler;
        // $matches[1] — первый захваченный параметр (id, name и т.д.)
        (new $controllerClass())->$method($matches[1]);
        $matched = true;
        break;
    }
}

if (!$matched) {
    http_response_code(404);
    echo '404 Not Found';
}
