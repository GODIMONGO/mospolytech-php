<?php /**
 * Боковая панель форума. Ожидает массив $sidebar с ключами
 * stats, categories, top_authors, hot (готовит ArticlesController).
 */ ?>
<aside class="sidebar">

    <div class="side-box">
        <h4>📊 Статистика форума</h4>
        <div class="side-stats">
            <div><b data-counter="<?= $sidebar['stats']['articles'] ?>">0</b><span>тем</span></div>
            <div><b data-counter="<?= $sidebar['stats']['comments'] ?>">0</b><span>ответов</span></div>
            <div><b data-counter="<?= $sidebar['stats']['users'] ?>">0</b><span>юзеров</span></div>
            <div><b data-counter="<?= $sidebar['stats']['views'] ?>">0</b><span>просмотров</span></div>
        </div>
    </div>

    <div class="side-box">
        <h4>🗂 Категории</h4>
        <ul class="side-list">
            <?php foreach ($sidebar['categories'] as $c): ?>
            <li>
                <a href="<?= $_SERVER['SCRIPT_NAME'] ?>/articles#cat-<?= md5($c['category']) ?>">
                    <?= htmlspecialchars($c['category']) ?>
                </a>
                <span class="badge"><?= $c['cnt'] ?></span>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="side-box">
        <h4>🔥 Горячие темы</h4>
        <ul class="side-list">
            <?php foreach ($sidebar['hot'] as $h): ?>
            <li>
                <a href="<?= $_SERVER['SCRIPT_NAME'] ?>/articles/<?= $h['id'] ?>">
                    <?= htmlspecialchars(mb_substr($h['title'], 0, 38)) ?><?= mb_strlen($h['title']) > 38 ? '…' : '' ?>
                </a>
                <span class="badge">💬 <?= $h['reply_count'] ?></span>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="side-box">
        <h4>👑 Топ авторов</h4>
        <ul class="side-list authors">
            <?php foreach ($sidebar['top_authors'] as $i => $a): ?>
            <li>
                <span class="rank">#<?= $i + 1 ?></span>
                <span class="au">
                    <b><?= htmlspecialchars($a['nickname']) ?></b>
                    <small><?= htmlspecialchars($a['role']) ?></small>
                </span>
                <span class="badge"><?= $a['cnt'] ?></span>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>

</aside>
