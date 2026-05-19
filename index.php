<?php
/**
 * Фронт-контроллер приложения.
 *
 * Все HTTP-запросы к сайту проходят через этот файл (так настроен сервер).
 * Здесь происходит:
 *   1. Регистрация автозагрузчика классов (PSR-4).
 *   2. Объявление функции render() для отрисовки шаблонов.
 *   3. Разбор URI и сопоставление его с таблицей маршрутов.
 *   4. Вызов нужного метода контроллера с передачей параметров.
 *   5. Обработка случая, когда маршрут не найден (404).
 */

// ---------------------------------------------------------------------------
// 1. Автозагрузка классов (PSR-4).
// Имя класса (с неймспейсом) преобразуется в путь к .php-файлу.
// Пример: \Controllers\HomeController → Controllers/HomeController.php
// ---------------------------------------------------------------------------
spl_autoload_register(function (string $className) {
    require_once __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';
});

// ---------------------------------------------------------------------------
// 2. Функция отрисовки шаблонов.
// Сначала рендерит "содержимое" страницы в строку $content, затем
// подключает общий layout, в котором уже доступны $title и $content.
// ---------------------------------------------------------------------------
function render(string $view, array $vars = []): void
{
    // extract превращает ключи массива в локальные переменные,
    // чтобы в шаблоне можно было писать $article вместо $vars['article'].
    extract($vars);

    // Буферизация вывода: всё, что напечатает шаблон $view,
    // попадает не в браузер, а в строку $content.
    ob_start();
    include __DIR__ . '/Views/' . $view . '.php';
    $content = ob_get_clean();

    // Подключаем общий каркас страницы (header, nav, footer).
    include __DIR__ . '/Views/layout.php';
}

// ---------------------------------------------------------------------------
// 3. Подготовка URI для роутера.
// Из полного URL вычленяем "путь маршрута", убирая:
//   - GET-параметры (через parse_url),
//   - базовый путь до index.php (через preg_replace),
//   - слэши по краям (через trim).
// Пример: "/Makurin/kurs/index.php/articles/1?x=1" → "articles/1"
// ---------------------------------------------------------------------------
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$uri = preg_replace('~^.*?/index\.php~', '', $uri);
$uri = trim($uri, '/');

// ---------------------------------------------------------------------------
// 4. Таблица маршрутов.
// Каждая запись: регулярное выражение → [класс контроллера, имя метода].
// При совпадении $matches[1] передаётся как параметр (id статьи и т.д.).
// ---------------------------------------------------------------------------
$routes = [
    '~^$~'                          => [\Controllers\HomeController::class,     'index'],      // GET  /
    '~^calculator$~'                => [\Controllers\HomeController::class,     'calculator'], // GET/POST /calculator
    '~^articles$~'                  => [\Controllers\ArticlesController::class, 'index'],      // GET  /articles
    '~^articles/(\d+)$~'            => [\Controllers\ArticlesController::class, 'show'],       // GET  /articles/{id}
    '~^articles/(\d+)/edit$~'       => [\Controllers\ArticlesController::class, 'edit'],       // GET/POST /articles/{id}/edit
    '~^articles/(\d+)/comments$~'   => [\Controllers\CommentsController::class, 'add'],        // POST /articles/{id}/comments
    '~^comments/(\d+)/edit$~'       => [\Controllers\CommentsController::class, 'edit'],       // GET/POST /comments/{id}/edit
];

// ---------------------------------------------------------------------------
// 5. Поиск подходящего маршрута и вызов контроллера.
// ---------------------------------------------------------------------------
$matched = false;
foreach ($routes as $pattern => $handler) {
    if (preg_match($pattern, $uri, $matches)) {
        [$class, $method] = $handler;
        $param = $matches[1] ?? null;

        // Если URI содержит параметр (например, id) — передаём его в метод,
        // иначе вызываем без аргументов.
        $param !== null
            ? (new $class())->$method((int) $param)
            : (new $class())->$method();

        $matched = true;
        break;
    }
}

// ---------------------------------------------------------------------------
// 6. Ни один маршрут не подошёл — отдаём страницу 404.
// ---------------------------------------------------------------------------
if (!$matched) {
    http_response_code(404);
    render('404', ['title' => '404 — Страница не найдена']);
}
