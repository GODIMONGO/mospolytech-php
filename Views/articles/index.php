<?php /**
 * Форумный список тем, сгруппированный по категориям.
 * $categories — массив [имя категории => массив тем].
 * $sidebar — данные для боковой панели.
 */ ?>

<div class="layout-grid">
<div class="forum-main">

    <div class="forum-head reveal visible">
        <div>
            <h1>Форум сообщества</h1>
            <p>Обсуждаем PHP, JavaScript, базы данных, DevOps и карьеру в IT</p>
        </div>
        <form class="forum-search" onsubmit="return false">
            <input type="text" id="topicSearch" placeholder="🔍 Поиск по темам...">
        </form>
    </div>

    <?php foreach ($categories as $catName => $topics): ?>
    <section class="cat-block reveal" id="cat-<?= md5($catName) ?>">
        <div class="cat-header">
            <h2><?= htmlspecialchars($catName) ?></h2>
            <span class="cat-count"><?= count($topics) ?> тем</span>
        </div>

        <div class="topic-list">
            <?php foreach ($topics as $t): ?>
            <a href="<?= $_SERVER['SCRIPT_NAME'] ?>/articles/<?= $t['id'] ?>" class="topic-row" data-title="<?= htmlspecialchars(mb_strtolower($t['title'])) ?>">
                <div class="topic-avatar"><?= mb_strtoupper(mb_substr($t['author_nickname'], 0, 1)) ?></div>
                <div class="topic-main">
                    <span class="topic-title"><?= htmlspecialchars($t['title']) ?></span>
                    <span class="topic-sub">
                        <?= htmlspecialchars($t['author_nickname']) ?>
                        · <em><?= htmlspecialchars($t['author_role']) ?></em>
                        · <?= $t['created_at'] ?>
                    </span>
                </div>
                <div class="topic-stat"><b><?= $t['reply_count'] ?></b><span>ответов</span></div>
                <div class="topic-stat"><b><?= $t['views'] ?></b><span>просмотров</span></div>
            </a>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endforeach; ?>

    <p class="no-results" id="noResults" style="display:none">Ничего не найдено 🤷</p>

</div>

<?php include __DIR__ . '/../partials/sidebar.php'; ?>
</div>
