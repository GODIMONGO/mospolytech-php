<?php

/**
 * Программа для решения уравнения вида: a OP X = b или X OP a = b
 * Вариант 2: 27 - X = 17
 */

/**
 * Разбирает уравнение и возвращает его компоненты.
 * Определяет оператор, позицию X и числовые значения.
 */
function parseEquation(string $equation): array {
    // Убираем пробелы и точку с запятой
    $equation = str_replace([' ', ';'], '', $equation);

    // Проверяем наличие знака '='
    if (!str_contains($equation, '=')) {
        throw new ЫInvalidArgumentException("Уравнение должно содержать знак '='");
    }

    // Разбиваем на левую и правую части
    [$left, $right] = explode('=', $equation, 2);

    if (!is_numeric($right)) {
        throw new InvalidArgumentException("Правая часть уравнения должна быть числом");
    }

    $result = (float)$right;

    // Определяем оператор и позицию X
    $operators = ['+', '-', '*', '/'];

    foreach ($operators as $op) {
        // Ищем оператор в левой части (не первым символом — чтобы не путать с унарным минусом)
        $pos = strpos($left, $op, 1);

        if ($pos === false) {
            continue;
        }

        $leftPart  = substr($left, 0, $pos);
        $rightPart = substr($left, $pos + 1);

        // Определяем, где стоит X
        if (strtoupper($leftPart) === 'X' && is_numeric($rightPart)) {
            return [
                'operator'    => $op,
                'x_position'  => 'left',   // X OP число = результат
                'known_value' => (float)$rightPart,
                'result'      => $result,
            ];
        }

        if (is_numeric($leftPart) && strtoupper($rightPart) === 'X') {
            return [
                'operator'    => $op,
                'x_position'  => 'right',  // число OP X = результат
                'known_value' => (float)$leftPart,
                'result'      => $result,
            ];
        }
    }

    throw new InvalidArgumentException("Не удалось распознать уравнение. Поддерживаемый формат: X OP a = b или a OP X = b");
}

/**
 * Вычисляет значение X на основе оператора и позиции переменной.
 */
function solveEquation(array $parsed): float {
    $op    = $parsed['operator'];
    $pos   = $parsed['x_position'];
    $a     = $parsed['known_value'];
    $b     = $parsed['result'];

    if ($pos === 'left') {
        // X OP a = b
        return match ($op) {
            '+' => $b - $a,
            '-' => $b + $a,
            '*' => ($a != 0) ? $b / $a : throw new DivisionByZeroError("Деление на ноль"),
            '/' => $b * $a,
            default => throw new InvalidArgumentException("Неизвестный оператор: $op"),
        };
    } else {
        // a OP X = b
        return match ($op) {
            '+' => $b - $a,
            '-' => $a - $b,
            '*' => ($a != 0) ? $b / $a : throw new DivisionByZeroError("Деление на ноль"),
            '/' => ($b != 0) ? $a / $b : throw new DivisionByZeroError("Деление на ноль"),
            default => throw new InvalidArgumentException("Неизвестный оператор: $op"),
        };
    }
}

/**
 * Форматирует и выводит результат решения.
 */
function printSolution(string $equation, array $parsed, float $x): void {
    $opNames = [
        '+' => 'сложение',
        '-' => 'вычитание',
        '*' => 'умножение',
        '/' => 'деление',
    ];

    $posLabel = ($parsed['x_position'] === 'left')
        ? 'X стоит СЛЕВА от оператора  (X OP a = b)'
        : 'X стоит СПРАВА от оператора (a OP X = b)';

    echo "Уравнение: {$equation}\n";
    echo "Оператор: {$parsed['operator']}  ({$opNames[$parsed['operator']]})\n";
    echo "Позиция X: {$posLabel}\n";
    echo "Результат: {$parsed['result']}\n";
    echo "Известное: {$parsed['known_value']}\n";

    // Форматируем X: если целое — без дробной части
    $xFormatted = (floor($x) == $x) ? (int)$x : $x;
    echo "  X = {$xFormatted}\n";
    echo "====\n";

    // Проверка подстановкой
    $check = verifyAnswer($parsed, $x);
    $status = $check ? "✓ Верно" : "✗ Ошибка";
    echo "  Проверка   : {$status}\n";
    echo "====\n\n";
}

/**
 * Проверяет правильность найденного X подстановкой в исходное уравнение.
 */
function verifyAnswer(array $parsed, float $x): bool {
    $op = $parsed['operator'];
    $a  = $parsed['known_value'];
    $b  = $parsed['result'];

    $lhs = ($parsed['x_position'] === 'left')
        ? match ($op) {
            '+' => $x + $a,
            '-' => $x - $a,
            '*' => $x * $a,
            '/' => ($a != 0) ? $x / $a : NAN,
        }
        : match ($op) {
            '+' => $a + $x,
            '-' => $a - $x,
            '*' => $a * $x,
            '/' => ($x != 0) ? $a / $x : NAN,
        };

    return abs($lhs - $b) < 1e-9;
}

// Уравнение варианта №2
$equations = [
    "27 - X = 17",   // вариант 2 — основное задание
];

// Дополнительно демонстрируем работу для всех форм уравнений
$demo = [
    "X + 3 = 7",     // X слева, сложение
    "27 - X = 17",   // X справа, вычитание  ← вариант 2
    "6 / X = 2",     // X справа, деление
    "X / 8 = 6",     // X слева, деление
    "22 * X = 220",  // X справа, умножение
    "X * 7 = 49",    // X слева, умножение
];

echo "<pre>\n";
echo "=== Решатель уравнений. Вариант 2: 27 - X = 17 ===\n\n";

foreach ($demo as $eq) {
    try {
        $parsed = parseEquation($eq);
        $x      = solveEquation($parsed);
        printSolution($eq, $parsed, $x);
        echo "\n";
    } catch (Throwable $e) {
        echo "Ошибка при разборе «{$eq}»: " . $e->getMessage() . "\n\n";
    }
}
echo "</pre>\n";