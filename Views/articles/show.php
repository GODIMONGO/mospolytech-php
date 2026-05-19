<?php /**
 * Страница темы форума: пост автора, ответы, форма ответа + боковая панель.
 * Получает $article, $author, $comments, $sidebar.
 */ ?>

<div class="layout-grid">
<div class="forum-main">

    <nav class="crumbs">
        <a href="<?= $_SERVER['SCRIPT_NAME'] ?>/articles">Форум</a>
        <span>→</span>
        <a href="<?= $_SERVER['SCRIPT_NAME'] ?>/articles#cat-<?= md5($article['category']) ?>"><?= htmlspecialchars($article['category']) ?></a>
        <span>→</span>
        <span class="cur"><?= htmlspecialchars(mb_substr($article['title'], 0, 40)) ?></span>
    </nav>

    <article>
        <h1><?= htmlspecialchars($article['title']) ?></h1>
        <div class="meta">
            <span class="chip"><?= htmlspecialchars($article['category']) ?></span>
            <span>✍ <b><?= htmlspecialchars($author['nickname']) ?></b> · <?= htmlspecialchars($author['role']) ?></span>
            <span>👁 <?= $article['views'] ?></span>
            <span>📅 <?= $article['created_at'] ?></span>
            <a href="<?= $_SERVER['SCRIPT_NAME'] ?>/articles/<?= $article['id'] ?>/edit">✎ Редактировать</a>
        </div>
        <div class="article-text">
            <p><?= nl2br(htmlspecialchars($article['text'])) ?></p>
        </div>
    </article>

    <section class="comments">
        <h2>💬 Ответы (<?= count($comments) ?>)</h2>

        <?php if (empty($comments)): ?>
            <p style="color:var(--text-dim)">Ответов пока нет. Будьте первым!</p>
        <?php else: ?>
            <?php foreach ($comments as $comment): ?>
            <div class="comment" id="comment<?= $comment['id'] ?>">
                <div class="comment-avatar"><?= mb_strtoupper(mb_substr($comment['author_nickname'], 0, 1)) ?></div>
                <div class="comment-body">
                    <div class="comment-meta">
                        <b><?= htmlspecialchars($comment['author_nickname']) ?></b>
                        <em><?= htmlspecialchars($comment['author_role']) ?></em>
                        <small><?= $comment['created_at'] ?></small>
                        <a href="<?= $_SERVER['SCRIPT_NAME'] ?>/comments/<?= $comment['id'] ?>/edit">✎</a>
                    </div>
                    <p><?= nl2br(htmlspecialchars($comment['text'])) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="comment-form">
            <h3 style="margin-bottom:14px">Оставить ответ</h3>
            <form method="post" action="<?= $_SERVER['SCRIPT_NAME'] ?>/articles/<?= $article['id'] ?>/comments">
                <textarea name="text" rows="4" placeholder="Ваш ответ в теме…"></textarea>
                <button type="submit" class="btn">Ответить</button>
            </form>
        </div>
    </section>

</div>

<?php include __DIR__ . '/../partials/sidebar.php'; ?>
</div>
