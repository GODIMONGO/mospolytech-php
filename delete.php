<?php
$db      = getDB();
$message = '';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    if ($id > 0) {
        $stmt = $db->prepare("SELECT surname FROM contacts WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $contact = $stmt->fetch();

        if ($contact) {
            try {
                $db->prepare("DELETE FROM contacts WHERE id = :id")->execute([':id' => $id]);
                $message = '<p class="success">Запись с фамилией '
                    . htmlspecialchars($contact['surname']) . ' удалена</p>';
            } catch (Exception $e) {
                $message = '<p class="error">Ошибка при удалении записи</p>';
            }
        } else {
            $message = '<p class="error">Запись не найдена</p>';
        }
    }
}

$contacts = $db->query(
    "SELECT id, surname, name, lastname FROM contacts ORDER BY surname ASC, name ASC"
)->fetchAll();

echo $message;

if (empty($contacts)) {
    echo '<p style="text-align:center;">Записей нет.</p>';
    return;
}
?>

<div class="div-edit" style="display:block; margin:20px auto; width:220px;">
    <?php foreach ($contacts as $c):
        $n  = mb_substr($c['name'],     0, 1, 'UTF-8');
        $l  = mb_strlen($c['lastname'], 'UTF-8') > 0
              ? mb_substr($c['lastname'], 0, 1, 'UTF-8') . '.'
              : '';
        $initials = $n . '.' . $l;
    ?>
        <a href="index.php?action=delete&id=<?= $c['id'] ?>">
            <?= htmlspecialchars($c['surname'] . ' ' . $initials) ?>
        </a>
    <?php endforeach; ?>
</div>
