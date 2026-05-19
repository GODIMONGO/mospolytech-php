// Получаем ссылки на поле ввода и форму
const display = document.getElementById('display');
const form    = document.getElementById('calc');

// Вставляем текст в позицию курсора в поле ввода
function insert(text) {
    const s = display.selectionStart ?? display.value.length;
    const e = display.selectionEnd   ?? display.value.length;
    display.value = display.value.slice(0, s) + text + display.value.slice(e);
    display.focus();
    display.setSelectionRange(s + text.length, s + text.length);
}

// Все кнопки с data-v заполняют поле через JS
document.querySelectorAll('button[data-v]').forEach(btn => {
    btn.addEventListener('click', () => insert(btn.dataset.v));
});

// Кнопка обнуления очищает поле
document.getElementById('clear').addEventListener('click', () => {
    display.value = '';
    display.focus();
});

// Бонус 2: ввод с клавиатуры. Поле <input> уже принимает ввод нативно,
// но Enter всё равно отправляет форму, а Esc очищает поле.
display.addEventListener('keydown', e => {
    if (e.key === 'Enter')  { e.preventDefault(); form.submit(); }
    if (e.key === 'Escape') { e.preventDefault(); display.value = ''; }
});
