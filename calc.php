<?php
// ============================================================
//   Серверная часть калькулятора.
//   1) принимает выражение из POST,
//   2) проверяет его корректность,
//   3) вычисляет через рекурсивные пользовательские функции,
//   4) возвращает результат обратно через GET-параметр.
// ============================================================


// -------- 1. Пользовательские функции операций --------
// По заданию: вычислять выражение нужно с помощью рекурсивных
// вызовов пользовательских функций для каждой операции.

function add($a, $b) { return $a + $b; }   // сложение
function sub($a, $b) { return $a - $b; }   // вычитание
function mul($a, $b) { return $a * $b; }   // умножение
function dvd($a, $b) {                     // деление с проверкой
    if ($b == 0) throw new Exception('деление на ноль');
    return $a / $b;
}

// Возведение в степень — рекурсивно для целой степени,
// иначе через стандартный pow (нужно для дробных степеней).
function pw($a, $b) {
    if (is_int($b) && $b >= 0) {
        if ($b === 0) return 1;
        return mul($a, pw($a, $b - 1));   // рекурсия
    }
    return pow($a, $b);
}

// Факториал — классическая рекурсия.
function fct($n) {
    if (!is_int($n) || $n < 0) throw new Exception('факториал требует целое >= 0');
    if ($n <= 1) return 1;
    return mul($n, fct($n - 1));
}


// -------- 2. Проверка корректности --------
function validate($s) {
    if ($s === '') throw new Exception('пустое выражение');

    // Допустимы: цифры, точка, операции, скобки, буквы (для pi, e, sqrt, ln, log)
    if (!preg_match('/^[0-9.+\-*\/()!^ a-zA-Z]+$/', $s))
        throw new Exception('недопустимые символы');

    // Проверяем баланс скобок
    $d = 0;
    for ($i = 0; $i < strlen($s); $i++) {
        if ($s[$i] === '(') $d++;
        if ($s[$i] === ')') $d--;
        if ($d < 0) throw new Exception('лишняя закрывающая скобка');
    }
    if ($d !== 0) throw new Exception('скобки не сбалансированы');
}


// -------- 3. Рекурсивный разбор и вычисление --------
// Грамматика (от низшего приоритета к высшему):
//   expr   = term  { (+|-) term }
//   term   = power { (*|/) power }
//   power  = unary [ ^ power ]
//   unary  = (+|-) unary | postfix
//   postfix= primary { ! }
//   primary= число | (expr) | pi | e | sqrt(expr) | ln(expr) | log(expr)
//
// Положение в строке храним в глобальной переменной $POS,
// строку — в $SRC. Это позволяет каждой функции просто
// рекурсивно вызывать другие, не передавая параметры.

$SRC = '';
$POS = 0;

// Пропускаем пробелы
function skip() {
    global $SRC, $POS;
    while ($POS < strlen($SRC) && $SRC[$POS] === ' ') $POS++;
}

// Смотрим текущий символ, не сдвигая позицию
function peek() {
    global $SRC, $POS;
    skip();
    return $POS < strlen($SRC) ? $SRC[$POS] : '';
}

// Проверяем, начинается ли выражение с ключевого слова (pi, e, sqrt, ln, log)
function word($w) {
    global $SRC, $POS;
    skip();
    $len = strlen($w);
    if (substr($SRC, $POS, $len) === $w) {
        $after = $POS + $len < strlen($SRC) ? $SRC[$POS + $len] : '';
        // Слово должно заканчиваться (не сливаться с другой буквой)
        if (!ctype_alpha($after)) { $POS += $len; return true; }
    }
    return false;
}

// Сложение и вычитание
function expr() {
    global $POS;
    $a = term();
    while (true) {
        $c = peek();
        if ($c === '+') { $POS++; $a = add($a, term()); }
        elseif ($c === '-') { $POS++; $a = sub($a, term()); }
        else break;
    }
    return $a;
}

// Умножение и деление
function term() {
    global $POS;
    $a = power();
    while (true) {
        $c = peek();
        if ($c === '*') { $POS++; $a = mul($a, power()); }
        elseif ($c === '/') { $POS++; $a = dvd($a, power()); }
        else break;
    }
    return $a;
}

// Возведение в степень (правоассоциативное: 2^3^2 = 2^(3^2))
function power() {
    global $POS;
    $a = unary();
    if (peek() === '^') { $POS++; $a = pw($a, power()); }
    return $a;
}

// Унарный плюс/минус — поддержка отрицательных чисел и отрицательных скобок
function unary() {
    global $POS;
    $c = peek();
    if ($c === '+') { $POS++; return unary(); }
    if ($c === '-') { $POS++; return sub(0, unary()); }
    return postfix();
}

// Постфиксный факториал: 5!
function postfix() {
    global $POS;
    $a = primary();
    while (peek() === '!') { $POS++; $a = fct($a); }
    return $a;
}

// Первичное выражение: число, скобки, константа или функция
function primary() {
    global $SRC, $POS;
    skip();
    if ($POS >= strlen($SRC)) throw new Exception('неожиданный конец выражения');
    $c = $SRC[$POS];

    // Скобки
    if ($c === '(') {
        $POS++;
        $v = expr();
        if (peek() !== ')') throw new Exception('ожидалась )');
        $POS++;
        return $v;
    }

    // Число (целое или дробное)
    if (ctype_digit($c) || $c === '.') {
        $start = $POS;
        while ($POS < strlen($SRC) && (ctype_digit($SRC[$POS]) || $SRC[$POS] === '.')) $POS++;
        $num = substr($SRC, $start, $POS - $start);
        if (substr_count($num, '.') > 1) throw new Exception('неверное число');
        return strpos($num, '.') !== false ? (float)$num : (int)$num;
    }

    // Константы
    if (word('pi')) return M_PI;
    if (word('e'))  return M_E;

    // Функции (вычисляют аргумент рекурсивно через expr())
    if (word('sqrt')) {
        if (peek() !== '(') throw new Exception('ожидалась (');
        $POS++; $v = expr();
        if (peek() !== ')') throw new Exception('ожидалась )');
        $POS++;
        if ($v < 0) throw new Exception('корень из отрицательного');
        return sqrt($v);
    }
    if (word('ln')) {
        if (peek() !== '(') throw new Exception('ожидалась (');
        $POS++; $v = expr();
        if (peek() !== ')') throw new Exception('ожидалась )');
        $POS++;
        if ($v <= 0) throw new Exception('ln от неположительного');
        return log($v);
    }
    if (word('log')) {
        if (peek() !== '(') throw new Exception('ожидалась (');
        $POS++; $v = expr();
        if (peek() !== ')') throw new Exception('ожидалась )');
        $POS++;
        if ($v <= 0) throw new Exception('log от неположительного');
        return log10($v);
    }

    throw new Exception("неожиданный символ '$c'");
}


// -------- 4. Запуск --------
$raw = isset($_POST['expression']) ? trim($_POST['expression']) : '';
$out = '';

try {
    validate($raw);
    $SRC = $raw;
    $POS = 0;
    $val = expr();                                // запуск рекурсивного разбора
    if ($POS !== strlen($SRC)) throw new Exception('лишние символы в конце');

    // Округляем дробные числа красиво
    if (is_float($val)) {
        $out = rtrim(rtrim(sprintf('%.10F', $val), '0'), '.');
        if ($out === '' || $out === '-') $out = '0';
    } else {
        $out = (string)$val;
    }
} catch (Throwable $e) {
    $out = 'Ошибка: ' . $e->getMessage();
}

// Передаём результат обратно через GET-параметр (по заданию)
header('Location: index.php?expr=' . rawurlencode($raw) . '&result=' . rawurlencode($out));
exit;
