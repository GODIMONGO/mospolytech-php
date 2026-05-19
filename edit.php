<?php
$db      = getDB();
$message = '';

$contacts = $db->query(
    "SELECT id, surname, name, lastname FROM contacts ORDER BY surname ASC, name ASC"
)->fetchAll();

if (empty($contacts)) {
    echo '<p style="text-align:center;">Нет записей для редактирования.</p>';
    return;
}

$currentId = isset($_GET['id']) ? (int)$_GET['id'] : (int)$contacts[0]['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button'])) {
    $id       = (int)($_POST['id']       ?? 0);
    $surname  = trim($_POST['surname']   ?? '');
    $name     = trim($_POST['name']      ?? '');
    $lastname = trim($_POST['lastname']  ?? '');
    $gender   = trim($_POST['gender']    ?? '');
    $date     = trim($_POST['date']      ?? '');
    $phone    = trim($_POST['phone']     ?? '');
    $location = trim($_POST['location']  ?? '');
    $email    = trim($_POST['email']     ?? '');
    $comment  = trim($_POST['comment']   ?? '');

    if ($id > 0 && $surname !== '' && $name !== '') {
        try {
            $stmt = $db->prepare(
                "UPDATE contacts SET surname=:surname,name=:name,lastname=:lastname,
                 gender=:gender,date=:date,phone=:phone,location=:location,
                 email=:email,comment=:comment WHERE id=:id"
            );
            $stmt->execute([
                ':id'       => $id,
                ':surname'  => $surname,
                ':name'     => $name,
                ':lastname' => $lastname,
                ':gender'   => $gender,
                ':date'     => $date,
                ':phone'    => $phone,
                ':location' => $location,
                ':email'    => $email,
                ':comment'  => $comment,
            ]);
            $message   = '<p class="success">Запись обновлена</p>';
            $currentId = $id;
            $contacts  = $db->query(
                "SELECT id, surname, name, lastname FROM contacts ORDER BY surname ASC, name ASC"
            )->fetchAll();
        } catch (Exception $e) {
            $message = '<p class="error">Ошибка: запись не обновлена</p>';
        }
    } else {
        $message = '<p class="error">Ошибка: заполните фамилию и имя</p>';
    }
}

$stmt = $db->prepare("SELECT * FROM contacts WHERE id = :id");
$stmt->execute([':id' => $currentId]);
$row = $stmt->fetch();

if (!$row) {
    $currentId = (int)$contacts[0]['id'];
    $stmt->execute([':id' => $currentId]);
    $row = $stmt->fetch();
}
?>

<?= $message ?>

<div class="edit-wrap">
    <div class="div-edit">
        <?php foreach ($contacts as $c): ?>
            <a href="index.php?action=edit&id=<?= $c['id'] ?>"
               class="<?= ((int)$c['id'] === $currentId) ? 'currentRow' : '' ?>">
                <?= htmlspecialchars($c['surname'] . ' ' . $c['name']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <form name="form_edit" method="post" action="index.php?action=edit&id=<?= $currentId ?>">
        <input type="hidden" name="id" value="<?= $currentId ?>">
        <div class="column" style="width:auto;">
            <div class="add">
                <label>Фамилия</label>
                <input type="text" name="surname" placeholder="Фамилия"
                       value="<?= htmlspecialchars($row['surname']) ?>" required>
            </div>
            <div class="add">
                <label>Имя</label>
                <input type="text" name="name" placeholder="Имя"
                       value="<?= htmlspecialchars($row['name']) ?>" required>
            </div>
            <div class="add">
                <label>Отчество</label>
                <input type="text" name="lastname" placeholder="Отчество"
                       value="<?= htmlspecialchars($row['lastname']) ?>">
            </div>
            <div class="add">
                <label>Пол</label>
                <select name="gender">
                    <option value="">— выберите —</option>
                    <option value="мужской"  <?= ($row['gender'] === 'мужской')  ? 'selected' : '' ?>>мужской</option>
                    <option value="женский"  <?= ($row['gender'] === 'женский')  ? 'selected' : '' ?>>женский</option>
                </select>
            </div>
            <div class="add">
                <label>Дата рождения</label>
                <input type="date" name="date" value="<?= htmlspecialchars($row['date']) ?>">
            </div>
            <div class="add">
                <label>Телефон</label>
                <input type="text" name="phone" placeholder="Телефон"
                       value="<?= htmlspecialchars($row['phone']) ?>">
            </div>
            <div class="add">
                <label>Адрес</label>
                <input type="text" name="location" placeholder="Адрес"
                       value="<?= htmlspecialchars($row['location']) ?>">
            </div>
            <div class="add">
                <label>Email</label>
                <input type="email" name="email" placeholder="Email"
                       value="<?= htmlspecialchars($row['email']) ?>">
            </div>
            <div class="add">
                <label>Комментарий</label>
                <textarea name="comment" placeholder="Краткий комментарий"><?= htmlspecialchars($row['comment']) ?></textarea>
            </div>
            <button type="submit" name="button" value="Сохранить" class="form-btn">Сохранить</button>
        </div>
    </form>
</div>
