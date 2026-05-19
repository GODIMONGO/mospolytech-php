<h1>Редактирование комментария #<?= $comment['id'] ?></h1>

<form method="post">
    <div>
        <label for="text">Текст</label><br>
        <textarea id="text" name="text" rows="6" cols="50"><?= htmlspecialchars($comment['text']) ?></textarea>
    </div>

    <button type="submit">Сохранить</button>
</form>
