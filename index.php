<?php

// Автозагрузка: преобразует имя класса в путь к файлу (Controllers\HomeController -> Controllers/HomeController.php)
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

// Получаем путь из URL и декодируем кириллицу
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$uri = rtrim($uri, '/');

$controller = new \Controllers\HomeController();

// Роутинг: /hello/{name} и /bye/{name}
if (preg_match('#/hello/(.+)$#', $uri, $matches)) {
    $controller->sayHello($matches[1]);
} elseif (preg_match('#/bye/(.+)$#', $uri, $matches)) {
    $controller->sayBye($matches[1]);
} else {
    http_response_code(404);
    echo '404 Not Found';
}
