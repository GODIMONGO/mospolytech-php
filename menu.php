<?php
function getMenu(): string {
    $action = $_GET['action'] ?? 'view';
    if (!in_array($action, ['view', 'add', 'edit', 'delete'])) {
        $action = 'view';
    }

    $items = [
        'view'   => 'Просмотр',
        'add'    => 'Добавление записи',
        'edit'   => 'Редактирование записи',
        'delete' => 'Удаление записи',
    ];

    $html = '';
    foreach ($items as $key => $label) {
        $class = ($action === $key) ? ' class="select"' : '';
        $html .= '<a href="index.php?action=' . $key . '"' . $class . '>' . $label . '</a>';
    }
    return $html;
}

function getSortMenu(): string {
    $sort = $_GET['sort'] ?? 'id';
    if (!in_array($sort, ['id', 'surname', 'date'])) {
        $sort = 'id';
    }

    $sorts = [
        'id'      => 'По порядку добавления',
        'surname' => 'По фамилии',
        'date'    => 'По дате рождения',
    ];

    $html = '<div class="submenu">';
    foreach ($sorts as $key => $label) {
        $class = ($sort === $key) ? ' class="select"' : '';
        $html .= '<a href="index.php?action=view&sort=' . $key . '"' . $class . '>' . $label . '</a>';
    }
    $html .= '</div>';
    return $html;
}
