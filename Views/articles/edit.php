<h1>Редактирование статьи #<?= $article['id'] ?></h1>

<form method="post">
    <div>
        <label for="title">Заголовок</label><br>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($article['title']) ?>">
    </div>

    <div>
        <label for="text">Текст</label><br>
        <textarea id="text" name="text" rows="6" cols="50"><?= htmlspecialchars($article['text']) ?></textarea>
    </div>

    <button type="submit">Сохранить</button>
</form>
