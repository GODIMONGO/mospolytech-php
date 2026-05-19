<h1>Редактирование статьи</h1>

<form method="post" class="edit-form">
    <label>Заголовок
        <input type="text" name="title" value="<?= htmlspecialchars($article['title']) ?>">
    </label>
    <label>Текст
        <textarea name="text" rows="10"><?= htmlspecialchars($article['text']) ?></textarea>
    </label>
    <button type="submit" class="btn">Сохранить</button>
    <a href="<?= $_SERVER['SCRIPT_NAME'] ?>/articles/<?= $article['id'] ?>" class="btn btn-outline">Отмена</a>
</form>
