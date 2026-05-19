<h1><?= htmlspecialchars($article['title']) ?></h1>

<p><?= htmlspecialchars($article['text']) ?></p>

<p>Автор: <b><?= htmlspecialchars($author['nickname']) ?></b></p>

<hr>

<h2>Комментарии</h2>

<?php if (empty($comments)): ?>
    <p>Комментариев пока нет.</p>
<?php else: ?>
    <?php foreach ($comments as $comment): ?>
        <div id="comment<?= $comment['id'] ?>">
            <b><?= htmlspecialchars($comment['author_nickname']) ?></b>
            <small><?= $comment['created_at'] ?></small>
            <p><?= htmlspecialchars($comment['text']) ?></p>
            <a href="<?= $_SERVER['SCRIPT_NAME'] ?>/comments/<?= $comment['id'] ?>/edit">Редактировать</a>
        </div>
        <hr>
    <?php endforeach; ?>
<?php endif; ?>

<h3>Добавить комментарий</h3>

<form method="post" action="<?= $_SERVER['SCRIPT_NAME'] ?>/articles/<?= $article['id'] ?>/comments">
    <textarea name="text" rows="4" cols="50" placeholder="Текст комментария"></textarea><br>
    <button type="submit">Отправить</button>
</form>
