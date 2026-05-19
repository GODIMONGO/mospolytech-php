<section class="hero">
    <h1>IT-блог</h1>
    <p>Статьи о PHP, MVC, ООП и веб-разработке. Плюс онлайн-калькулятор с рекурсивным вычислителем.</p>
    <a href="<?= $_SERVER['SCRIPT_NAME'] ?>/articles" class="btn">Все статьи</a>
    <a href="<?= $_SERVER['SCRIPT_NAME'] ?>/calculator" class="btn btn-outline">Калькулятор</a>
</section>

<section>
    <h2>Последние статьи</h2>
    <div class="articles-grid">
        <?php foreach ($articles as $article): ?>
        <div class="card">
            <h3><a href="<?= $_SERVER['SCRIPT_NAME'] ?>/articles/<?= $article['id'] ?>">
                <?= htmlspecialchars($article['title']) ?>
            </a></h3>
            <p><?= htmlspecialchars(mb_substr($article['text'], 0, 120)) ?>…</p>
            <small>Автор: <?= htmlspecialchars($article['author_nickname']) ?></small>
        </div>
        <?php endforeach; ?>
    </div>
</section>
