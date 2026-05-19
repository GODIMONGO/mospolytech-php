<?php /**
 * Страница одной статьи: текст, автор, комментарии и форма добавления.
 * Получает $article, $author, $comments.
 */ ?>

<article>
    <h1><?= htmlspecialchars($article['title']) ?></h1>
    <div class="meta">
        <span>✍ <b><?= htmlspecialchars($author['nickname']) ?></b></span>
        <span>📅 <?= $article['created_at'] ?></span>
        <a href="<?= $_SERVER['SCRIPT_NAME'] ?>/articles/<?= $article['id'] ?>/edit">✎ Редактировать</a>
    </div>
    <div class="article-text">
        <?php /* nl2br сохраняет переводы строк, htmlspecialchars защищает от XSS */ ?>
        <p><?= nl2br(htmlspecialchars($article['text'])) ?></p>
    </div>
</article>

<section class="comments">
    <h2>💬 Комментарии (<?= count($comments) ?>)</h2>

    <?php if (empty($comments)): ?>
        <p style="color:var(--text-dim)">Комментариев пока нет. Будьте первым!</p>
    <?php else: ?>
        <?php foreach ($comments as $comment): ?>
        <div class="comment" id="comment<?= $comment['id'] ?>">
            <div class="comment-meta">
                <b><?= htmlspecialchars($comment['author_nickname']) ?></b>
                <small><?= $comment['created_at'] ?></small>
                <a href="<?= $_SERVER['SCRIPT_NAME'] ?>/comments/<?= $comment['id'] ?>/edit">✎ Редактировать</a>
            </div>
            <p><?= nl2br(htmlspecialchars($comment['text'])) ?></p>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <div class="comment-form">
        <h3 style="margin-bottom:14px">Добавить комментарий</h3>
        <form method="post" action="<?= $_SERVER['SCRIPT_NAME'] ?>/articles/<?= $article['id'] ?>/comments">
            <textarea name="text" rows="4" placeholder="Поделитесь мнением…"></textarea>
            <button type="submit" class="btn">Отправить</button>
        </form>
    </div>
</section>
