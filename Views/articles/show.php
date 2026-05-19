<article>
    <h1><?= htmlspecialchars($article['title']) ?></h1>
    <div class="meta">
        Автор: <b><?= htmlspecialchars($author['nickname']) ?></b>
        &nbsp;·&nbsp; <?= $article['created_at'] ?>
        &nbsp;·&nbsp; <a href="<?= $_SERVER['SCRIPT_NAME'] ?>/articles/<?= $article['id'] ?>/edit">Редактировать</a>
    </div>
    <div class="article-text">
        <p><?= nl2br(htmlspecialchars($article['text'])) ?></p>
    </div>
</article>

<section class="comments">
    <h2>Комментарии (<?= count($comments) ?>)</h2>

    <?php if (empty($comments)): ?>
        <p>Комментариев пока нет. Будьте первым!</p>
    <?php else: ?>
        <?php foreach ($comments as $comment): ?>
        <div class="comment" id="comment<?= $comment['id'] ?>">
            <div class="comment-meta">
                <b><?= htmlspecialchars($comment['author_nickname']) ?></b>
                <small><?= $comment['created_at'] ?></small>
                <a href="<?= $_SERVER['SCRIPT_NAME'] ?>/comments/<?= $comment['id'] ?>/edit">Редактировать</a>
            </div>
            <p><?= nl2br(htmlspecialchars($comment['text'])) ?></p>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <h3>Добавить комментарий</h3>
    <form method="post"
          action="<?= $_SERVER['SCRIPT_NAME'] ?>/articles/<?= $article['id'] ?>/comments"
          class="comment-form">
        <textarea name="text" rows="4" placeholder="Ваш комментарий…"></textarea>
        <button type="submit" class="btn">Отправить</button>
    </form>
</section>
