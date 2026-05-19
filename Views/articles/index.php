<h1>Статьи</h1>

<div class="articles-grid">
    <?php foreach ($articles as $article): ?>
    <div class="card">
        <h2><a href="<?= $_SERVER['SCRIPT_NAME'] ?>/articles/<?= $article['id'] ?>">
            <?= htmlspecialchars($article['title']) ?>
        </a></h2>
        <p><?= htmlspecialchars(mb_substr($article['text'], 0, 150)) ?>…</p>
        <div class="card-meta">
            <small>Автор: <b><?= htmlspecialchars($article['author_nickname']) ?></b></small>
            <small><?= $article['created_at'] ?></small>
        </div>
        <a href="<?= $_SERVER['SCRIPT_NAME'] ?>/articles/<?= $article['id'] ?>" class="btn">Читать</a>
    </div>
    <?php endforeach; ?>
</div>
