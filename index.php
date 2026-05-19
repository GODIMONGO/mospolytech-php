<?php
require_once 'db.php';
require_once 'menu.php';

$action = $_GET['action'] ?? 'view';
if (!in_array($action, ['view', 'add', 'edit', 'delete'])) {
    $action = 'view';
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Записная книжка</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <?= getMenu() ?>
</header>

<?php if ($action === 'view'): ?>
    <?= getSortMenu() ?>
<?php endif; ?>

<main>
<?php
switch ($action) {
    case 'view':
        require_once 'viewer.php';
        $sort = $_GET['sort'] ?? 'id';
        if (!in_array($sort, ['id', 'surname', 'date'])) $sort = 'id';
        $page = max(1, (int)($_GET['page'] ?? 1));
        echo getViewer($sort, $page);
        break;

    case 'add':
        require_once 'add.php';
        break;

    case 'edit':
        require_once 'edit.php';
        break;

    case 'delete':
        require_once 'delete.php';
        break;
}
?>
</main>

<footer></footer>

</body>
</html>
