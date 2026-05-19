<?php /**
 * Главная форума. Получает $latest (свежие темы), $categories, $stats.
 */
// Иконки и цвета для категорий
$catIcons = [
    'PHP' => '🐘', 'JavaScript' => '⚡', 'Базы данных' => '🗄',
    'DevOps' => '🐳', 'Frontend' => '🎨', 'Алгоритмы' => '🧮', 'Карьера' => '🚀',
];
?>

<section class="hero">
    <span class="hero-badge">⚡ Сообщество разработчиков</span>
    <h1>IT-форум <span class="accent">DevHub</span><br>знания, которые работают</h1>
    <p>Тысячи тем по PHP, JavaScript, базам данных, DevOps и карьере. Задавай вопросы, делись опытом, прокачивайся вместе с сообществом.</p>
    <div class="hero-actions">
        <a href="<?= $_SERVER['SCRIPT_NAME'] ?>/articles" class="btn">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/></svg>
            Перейти на форум
        </a>
        <a href="<?= $_SERVER['SCRIPT_NAME'] ?>/calculator" class="btn btn-outline">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM8 17H6v-2h2v2zm0-4H6v-2h2v2zm0-4H6V7h2v2zm5 8h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2V7h2v2zm5 8h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
            Калькулятор
        </a>
    </div>
</section>

<section class="section reveal">
    <div class="stats">
        <div><span class="stat-value" data-counter="<?= $stats['articles'] ?>">0</span><div class="stat-label">Тем на форуме</div></div>
        <div><span class="stat-value" data-counter="<?= $stats['comments'] ?>">0</span><div class="stat-label">Ответов</div></div>
        <div><span class="stat-value" data-counter="<?= $stats['users'] ?>">0</span><div class="stat-label">Участников</div></div>
        <div><span class="stat-value" data-counter="<?= $stats['views'] ?>">0</span><div class="stat-label">Просмотров</div></div>
    </div>
</section>

<section class="section reveal">
    <div class="section-header">
        <h2>Разделы форума</h2>
        <p>Выбери категорию и присоединяйся к обсуждению</p>
    </div>
    <div class="cat-grid">
        <?php foreach ($categories as $c): ?>
        <a href="<?= $_SERVER['SCRIPT_NAME'] ?>/articles#cat-<?= md5($c['category']) ?>" class="cat-card">
            <div class="cat-icon"><?= $catIcons[$c['category']] ?? '📁' ?></div>
            <div class="cat-info">
                <h3><?= htmlspecialchars($c['category']) ?></h3>
                <span><?= $c['cnt'] ?> тем · <?= (int)$c['views'] ?> просмотров</span>
            </div>
            <span class="cat-arrow">→</span>
        </a>
        <?php endforeach; ?>
    </div>
</section>

<section class="section reveal">
    <div class="section-header">
        <h2>Свежие темы</h2>
        <p>Самые новые обсуждения сообщества</p>
    </div>
    <div class="articles-grid">
        <?php foreach ($latest as $a): ?>
        <div class="card">
            <span class="chip"><?= htmlspecialchars($a['category']) ?></span>
            <h3><a href="<?= $_SERVER['SCRIPT_NAME'] ?>/articles/<?= $a['id'] ?>">
                <?= htmlspecialchars($a['title']) ?>
            </a></h3>
            <p><?= htmlspecialchars(mb_substr($a['text'], 0, 110)) ?>…</p>
            <div class="card-meta">
                <span><b><?= htmlspecialchars($a['author_nickname']) ?></b></span>
                <span>💬 <?= $a['reply_count'] ?> · 👁 <?= $a['views'] ?></span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
