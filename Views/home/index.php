<?php /**
 * Главная страница.
 * Получает $articles (последние статьи) и $stats (счётчики) от HomeController::index().
 */ ?>

<section class="hero">
    <span class="hero-badge">⚡ MVC-фреймворк собственной разработки</span>
    <h1>Блог о <span class="accent">современной</span><br>веб-разработке</h1>
    <p>Статьи о PHP, ООП, архитектуре MVC и паттернах проектирования. Плюс интерактивный калькулятор с рекурсивным парсером выражений.</p>
    <div class="hero-actions">
        <a href="<?= $_SERVER['SCRIPT_NAME'] ?>/articles" class="btn">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM7 7h10v2H7V7zm0 4h10v2H7v-2zm0 4h7v2H7v-2z"/></svg>
            Читать статьи
        </a>
        <a href="<?= $_SERVER['SCRIPT_NAME'] ?>/calculator" class="btn btn-outline">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM8 17H6v-2h2v2zm0-4H6v-2h2v2zm0-4H6V7h2v2zm5 8h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2V7h2v2zm5 8h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
            Калькулятор
        </a>
    </div>
</section>

<section class="section reveal">
    <div class="stats">
        <div>
            <span class="stat-value" data-counter="<?= $stats['articles'] ?>">0</span>
            <div class="stat-label">Статей опубликовано</div>
        </div>
        <div>
            <span class="stat-value" data-counter="<?= $stats['comments'] ?>">0</span>
            <div class="stat-label">Комментариев</div>
        </div>
        <div>
            <span class="stat-value" data-counter="<?= $stats['users'] ?>">0</span>
            <div class="stat-label">Авторов</div>
        </div>
        <div>
            <span class="stat-value" data-counter="7">0</span>
            <div class="stat-label">Маршрутов</div>
        </div>
    </div>
</section>

<section class="section reveal">
    <div class="section-header">
        <h2>Что под капотом</h2>
        <p>Сайт построен на чистом PHP без сторонних фреймворков</p>
    </div>
    <div class="features">
        <div class="feature">
            <div class="feature-icon">
                <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            </div>
            <h3>MVC-архитектура</h3>
            <p>Чёткое разделение на контроллеры, представления и работу с данными. Фронт-контроллер и таблица маршрутов на регулярных выражениях.</p>
        </div>
        <div class="feature">
            <div class="feature-icon">
                <svg viewBox="0 0 24 24"><path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/></svg>
            </div>
            <h3>PSR-4 автозагрузка</h3>
            <p>Классы подгружаются автоматически по неймспейсу через spl_autoload_register. Никаких ручных require.</p>
        </div>
        <div class="feature">
            <div class="feature-icon">
                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
            </div>
            <h3>Защита от инъекций</h3>
            <p>Все запросы к БД через подготовленные выражения PDO. Пользовательский ввод экранируется htmlspecialchars.</p>
        </div>
        <div class="feature">
            <div class="feature-icon">
                <svg viewBox="0 0 24 24"><path d="M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 002 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/></svg>
            </div>
            <h3>Комментарии</h3>
            <p>К любой статье можно оставить и отредактировать комментарий. Якорная навигация прямо к нужному комментарию.</p>
        </div>
        <div class="feature">
            <div class="feature-icon">
                <svg viewBox="0 0 24 24"><path d="M22 9.24l-7.19-.62L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27 18.18 21l-1.63-7.03L22 9.24z"/></svg>
            </div>
            <h3>Рекурсивный парсер</h3>
            <p>Калькулятор разбирает выражения методом рекурсивного спуска: степени, факториалы, функции, скобки.</p>
        </div>
        <div class="feature">
            <div class="feature-icon">
                <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
            </div>
            <h3>Адаптивный дизайн</h3>
            <p>Тёмная тема, glassmorphism, плавные анимации и появление контента при скролле. Корректно на мобильных.</p>
        </div>
    </div>
</section>

<section class="section reveal">
    <div class="section-header">
        <h2>Свежие статьи</h2>
        <p>Последние публикации в блоге</p>
    </div>
    <div class="articles-grid">
        <?php foreach ($articles as $article): ?>
        <div class="card">
            <h3><a href="<?= $_SERVER['SCRIPT_NAME'] ?>/articles/<?= $article['id'] ?>">
                <?= htmlspecialchars($article['title']) ?>
            </a></h3>
            <p><?= htmlspecialchars(mb_substr($article['text'], 0, 130)) ?>…</p>
            <div class="card-meta">
                <span>Автор: <b><?= htmlspecialchars($article['author_nickname']) ?></b></span>
                <span><?= $article['created_at'] ?></span>
            </div>
            <a href="<?= $_SERVER['SCRIPT_NAME'] ?>/articles/<?= $article['id'] ?>" class="btn">Читать →</a>
        </div>
        <?php endforeach; ?>
    </div>
</section>
