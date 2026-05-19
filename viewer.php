<?php
function getViewer(string $sort, int $page): string {
    $db = getDB();
    $perPage = 10;
    $offset  = ($page - 1) * $perPage;

    $orderMap = [
        'id'      => 'id ASC',
        'surname' => 'surname ASC',
        'date'    => 'date ASC',
    ];
    $order = $orderMap[$sort] ?? 'id ASC';

    $total      = (int)$db->query("SELECT COUNT(*) FROM contacts")->fetchColumn();
    $totalPages = (int)ceil($total / $perPage);
    if ($totalPages < 1) $totalPages = 1;

    $stmt = $db->prepare("SELECT * FROM contacts ORDER BY $order LIMIT :lim OFFSET :off");
    $stmt->bindValue(':lim', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':off', $offset,  PDO::PARAM_INT);
    $stmt->execute();
    $contacts = $stmt->fetchAll();

    $html  = '<table>';
    $html .= '<tr>
        <th>№</th>
        <th>Фамилия</th>
        <th>Имя</th>
        <th>Отчество</th>
        <th>Пол</th>
        <th>Дата рождения</th>
        <th>Телефон</th>
        <th>Адрес</th>
        <th>Email</th>
        <th>Комментарий</th>
    </tr>';

    if (empty($contacts)) {
        $html .= '<tr><td colspan="10">Записей нет</td></tr>';
    } else {
        foreach ($contacts as $i => $row) {
            $html .= '<tr>';
            $html .= '<td>' . ($offset + $i + 1) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['surname'])  . '</td>';
            $html .= '<td>' . htmlspecialchars($row['name'])     . '</td>';
            $html .= '<td>' . htmlspecialchars($row['lastname']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['gender'])   . '</td>';
            $html .= '<td>' . htmlspecialchars($row['date'])     . '</td>';
            $html .= '<td>' . htmlspecialchars($row['phone'])    . '</td>';
            $html .= '<td>' . htmlspecialchars($row['location']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['email'])    . '</td>';
            $html .= '<td>' . htmlspecialchars($row['comment'])  . '</td>';
            $html .= '</tr>';
        }
    }
    $html .= '</table>';

    if ($totalPages > 1) {
        $html .= '<div class="pagination">';
        for ($i = 1; $i <= $totalPages; $i++) {
            $class = ($i === $page) ? ' class="current-page"' : '';
            $html .= '<a href="index.php?action=view&sort=' . $sort . '&page=' . $i . '"' . $class . '>' . $i . '</a>';
        }
        $html .= '</div>';
    }

    return $html;
}
