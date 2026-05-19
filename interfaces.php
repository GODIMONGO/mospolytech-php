<?php

// Интерфейс — контракт: любой класс, реализующий его, ОБЯЗАН иметь метод calculateSquare()
// Сам интерфейс не содержит реализации, только сигнатуру метода
interface CalculateSquare
{
    public function calculateSquare(): float;
}

// Круг реализует интерфейс — ключевое слово implements
class Circle implements CalculateSquare
{
    // Краткий синтаксис PHP 8: свойство объявляется прямо в параметре конструктора
    public function __construct(private float $radius) {}

    // Площадь круга: π × r²
    public function calculateSquare(): float
    {
        return M_PI * $this->radius ** 2;
    }
}

// Прямоугольник тоже реализует интерфейс
class Rectangle implements CalculateSquare
{
    public function __construct(private float $width, private float $height) {}

    // Площадь прямоугольника: ширина × высота
    public function calculateSquare(): float
    {
        return $this->width * $this->height;
    }
}

// Треугольник НЕ реализует интерфейс — нет implements CalculateSquare
class Triangle
{
    public function __construct(private float $base, private float $height) {}
}

// Функция принимает любой объект и проверяет, реализует ли он интерфейс
function describeObject(object $obj): void
{
    // get_class() возвращает имя класса объекта в виде строки
    $className = get_class($obj);

    // instanceof проверяет, реализует ли объект данный интерфейс (или является наследником)
    if ($obj instanceof CalculateSquare) {
        echo 'Объект класса ' . $className . '. Площадь: ' . $obj->calculateSquare() . PHP_EOL;
    } else {
        echo 'Объект класса ' . $className . ' не реализует интерфейс CalculateSquare' . PHP_EOL;
    }
}

$circle    = new Circle(5);
$rectangle = new Rectangle(4, 6);
$triangle  = new Triangle(3, 8);

// Вывод: "Объект класса Circle. Площадь: 78.539..."
describeObject($circle);
// Вывод: "Объект класса Rectangle. Площадь: 24"
describeObject($rectangle);
// Вывод: "Объект класса Triangle не реализует интерфейс CalculateSquare"
describeObject($triangle);
