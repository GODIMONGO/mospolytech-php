<?php /**
 * Список всех статей. Принимает $articles от ArticlesController::index().
 */ ?>

<div class="section-header reveal visible">
    <h2>Все статьи</h2>
    <p>Полный архив публикаций блога</p>
</div>

<div class="articles-grid">
    <?php foreach ($articles as $article): ?>
    <div class="card reveal">
        <h2><a href="<?= $_SERVER['SCRIPT_NAME'] ?>/articles/<?= $article['id'] ?>">
            <?= htmlspecialchars($article['title']) ?>
        </a></h2>
        <p><?= htmlspecialchars(mb_substr($article['text'], 0, 160)) ?>…</p>
        <div class="card-meta">
            <span>Автор: <b><?= htmlspecialchars($article['author_nickname']) ?></b></span>
            <span><?= $article['created_at'] ?></span>
        </div>
        <a href="<?= $_SERVER['SCRIPT_NAME'] ?>/articles/<?= $article['id'] ?>" class="btn">Читать →</a>
    </div>
    <?php endforeach; ?>
</div>
