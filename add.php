<?php
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button'])) {
    $surname  = trim($_POST['surname']  ?? '');
    $name     = trim($_POST['name']     ?? '');
    $lastname = trim($_POST['lastname'] ?? '');
    $gender   = trim($_POST['gender']   ?? '');
    $date     = trim($_POST['date']     ?? '');
    $phone    = trim($_POST['phone']    ?? '');
    $location = trim($_POST['location'] ?? '');
    $email    = trim($_POST['email']    ?? '');
    $comment  = trim($_POST['comment']  ?? '');

    if ($surname !== '' && $name !== '') {
        try {
            $db   = getDB();
            $stmt = $db->prepare(
                "INSERT INTO contacts (surname,name,lastname,gender,date,phone,location,email,comment)
                 VALUES (:surname,:name,:lastname,:gender,:date,:phone,:location,:email,:comment)"
            );
            $stmt->execute([
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
            $message = '<p class="success">Запись добавлена</p>';
        } catch (Exception $e) {
            $message = '<p class="error">Ошибка: запись не добавлена</p>';
        }
    } else {
        $message = '<p class="error">Ошибка: запись не добавлена — заполните фамилию и имя</p>';
    }
}
?>

<?= $message ?>

<form name="form_add" method="post" action="index.php?action=add">
    <div class="column">
        <div class="add">
            <label>Фамилия</label>
            <input type="text" name="surname" placeholder="Фамилия" required>
        </div>
        <div class="add">
            <label>Имя</label>
            <input type="text" name="name" placeholder="Имя" required>
        </div>
        <div class="add">
            <label>Отчество</label>
            <input type="text" name="lastname" placeholder="Отчество">
        </div>
        <div class="add">
            <label>Пол</label>
            <select name="gender">
                <option value="">— выберите —</option>
                <option value="мужской">мужской</option>
                <option value="женский">женский</option>
            </select>
        </div>
        <div class="add">
            <label>Дата рождения</label>
            <input type="date" name="date">
        </div>
        <div class="add">
            <label>Телефон</label>
            <input type="text" name="phone" placeholder="Телефон">
        </div>
        <div class="add">
            <label>Адрес</label>
            <input type="text" name="location" placeholder="Адрес">
        </div>
        <div class="add">
            <label>Email</label>
            <input type="email" name="email" placeholder="Email">
        </div>
        <div class="add">
            <label>Комментарий</label>
            <textarea name="comment" placeholder="Краткий комментарий"></textarea>
        </div>
        <button type="submit" name="button" value="Добавить" class="form-btn">Добавить</button>
    </div>
</form>
