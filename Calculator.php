<?php

// Калькулятор на основе рекурсивного парсера.
// Вся логика инкапсулирована в класс (ООП, лаба 6).
class Calculator
{
    private string $src = '';
    private int    $pos = 0;

    public function evaluate(string $expression): string
    {
        $this->src = $expression;
        $this->pos = 0;
        $this->validate($expression);
        $result = $this->expr();
        if ($this->pos !== strlen($this->src)) {
            throw new Exception("лишние символы в конце");
        }
        if (is_float($result)) {
            $out = rtrim(rtrim(sprintf('%.10F', $result), '0'), '.');
            return $out === '' || $out === '-' ? '0' : $out;
        }
        return (string) $result;
    }

    private function validate(string $s): void
    {
        if ($s === '') throw new Exception('пустое выражение');
        if (!preg_match('/^[0-9.+\-*\/()!^ a-zA-Z]+$/', $s))
            throw new Exception('недопустимые символы');
        $depth = 0;
        for ($i = 0; $i < strlen($s); $i++) {
            if ($s[$i] === '(') $depth++;
            if ($s[$i] === ')') $depth--;
            if ($depth < 0) throw new Exception('лишняя закрывающая скобка');
        }
        if ($depth !== 0) throw new Exception('скобки не сбалансированы');
    }

    private function skip(): void
    {
        while ($this->pos < strlen($this->src) && $this->src[$this->pos] === ' ') {
            $this->pos++;
        }
    }

    private function peek(): string
    {
        $this->skip();
        return $this->pos < strlen($this->src) ? $this->src[$this->pos] : '';
    }

    private function word(string $w): bool
    {
        $this->skip();
        $len   = strlen($w);
        $after = $this->pos + $len < strlen($this->src) ? $this->src[$this->pos + $len] : '';
        if (substr($this->src, $this->pos, $len) === $w && !ctype_alpha($after)) {
            $this->pos += $len;
            return true;
        }
        return false;
    }

    private function expr(): float|int
    {
        $a = $this->term();
        while (true) {
            $c = $this->peek();
            if ($c === '+') { $this->pos++; $a += $this->term(); }
            elseif ($c === '-') { $this->pos++; $a -= $this->term(); }
            else break;
        }
        return $a;
    }

    private function term(): float|int
    {
        $a = $this->power();
        while (true) {
            $c = $this->peek();
            if ($c === '*') { $this->pos++; $a *= $this->power(); }
            elseif ($c === '/') {
                $this->pos++;
                $b = $this->power();
                if ($b == 0) throw new Exception('деление на ноль');
                $a /= $b;
            }
            else break;
        }
        return $a;
    }

    private function power(): float|int
    {
        $a = $this->unary();
        if ($this->peek() === '^') {
            $this->pos++;
            $a = $this->powRecursive($a, $this->power());
        }
        return $a;
    }

    // Рекурсивное возведение в степень (лаба 2.2)
    private function powRecursive(float|int $a, float|int $b): float|int
    {
        if (is_int($b) && $b >= 0) {
            if ($b === 0) return 1;
            return $a * $this->powRecursive($a, $b - 1);
        }
        return pow($a, $b);
    }

    private function unary(): float|int
    {
        $c = $this->peek();
        if ($c === '+') { $this->pos++; return $this->unary(); }
        if ($c === '-') { $this->pos++; return -$this->unary(); }
        return $this->postfix();
    }

    private function postfix(): float|int
    {
        $a = $this->primary();
        while ($this->peek() === '!') {
            $this->pos++;
            $a = $this->factorial($a);
        }
        return $a;
    }

    // Рекурсивный факториал (лаба 2.2)
    private function factorial(float|int $n): int
    {
        if (!is_int($n) || $n < 0) throw new Exception('факториал требует целое >= 0');
        if ($n <= 1) return 1;
        return $n * $this->factorial($n - 1);
    }

    private function primary(): float|int
    {
        $this->skip();
        if ($this->pos >= strlen($this->src)) throw new Exception('неожиданный конец');
        $c = $this->src[$this->pos];

        if ($c === '(') {
            $this->pos++;
            $v = $this->expr();
            if ($this->peek() !== ')') throw new Exception('ожидалась )');
            $this->pos++;
            return $v;
        }

        if (ctype_digit($c) || $c === '.') {
            $start = $this->pos;
            while ($this->pos < strlen($this->src) &&
                   (ctype_digit($this->src[$this->pos]) || $this->src[$this->pos] === '.')) {
                $this->pos++;
            }
            $num = substr($this->src, $start, $this->pos - $start);
            return str_contains($num, '.') ? (float) $num : (int) $num;
        }

        if ($this->word('pi'))   return M_PI;
        if ($this->word('e'))    return M_E;
        if ($this->word('sqrt')) return $this->mathFunc(fn($v) => $v < 0 ? throw new Exception('корень из отрицательного') : sqrt($v));
        if ($this->word('ln'))   return $this->mathFunc(fn($v) => $v <= 0 ? throw new Exception('ln от неположительного') : log($v));
        if ($this->word('log'))  return $this->mathFunc(fn($v) => $v <= 0 ? throw new Exception('log от неположительного') : log10($v));

        throw new Exception("неожиданный символ '$c'");
    }

    private function mathFunc(callable $fn): float|int
    {
        if ($this->peek() !== '(') throw new Exception('ожидалась (');
        $this->pos++;
        $v = $this->expr();
        if ($this->peek() !== ')') throw new Exception('ожидалась )');
        $this->pos++;
        return $fn($v);
    }
}
