// =========================================================================
// Интерактив: появление элементов при скролле + подсветка активной ссылки.
// =========================================================================

// Появление при скролле через IntersectionObserver
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.15, rootMargin: '0px 0px -50px 0px' });

document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

// Подсветка активного пункта меню по текущему URL
const currentPath = window.location.pathname;
document.querySelectorAll('nav a').forEach(link => {
    const linkPath = link.getAttribute('href');
    if (linkPath && linkPath !== '/' && currentPath.includes(linkPath.replace(/^.*\/index\.php/, ''))) {
        link.classList.add('active');
    } else if (linkPath && currentPath.endsWith('/index.php/') || currentPath.endsWith('/index.php')) {
        document.querySelector('nav a[href$="/"]')?.classList.add('active');
    }
});

// Анимация чисел статистики (счётчик от 0 до целевого значения)
const counters = document.querySelectorAll('[data-counter]');
const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        const el = entry.target;
        const target = parseInt(el.dataset.counter, 10);
        const duration = 1200;
        const start = performance.now();
        const step = (now) => {
            const progress = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.floor(target * eased);
            if (progress < 1) requestAnimationFrame(step);
            else el.textContent = target;
        };
        requestAnimationFrame(step);
        counterObserver.unobserve(el);
    });
}, { threshold: 0.5 });
counters.forEach(el => counterObserver.observe(el));
