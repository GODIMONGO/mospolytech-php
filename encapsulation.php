<?php

// Инкапсуляция — скрываем внутренние данные объекта от внешнего кода
// Свойства приватные: напрямую $cat->color = '...' сделать нельзя
class Cat
{
    private string $name;  // имя кошки — только для чтения внутри класса
    private string $color; // цвет кошки — доступен снаружи только через геттер

    // Конструктор — задаёт имя и цвет при создании объекта
    public function __construct(string $name, string $color)
    {
        $this->name  = $name;
        $this->color = $color;
    }

    // Геттер для color — единственный способ узнать цвет кошки извне
    public function getColor(): string
    {
        return $this->color;
    }

    // Кошка называет своё имя и говорит о своём цвете
    public function sayHello(): string
    {
        return 'Привет! Меня зовут ' . $this->name . '. Я ' . $this->color . ' кошка.';
    }
}

$cat1 = new Cat('Мурка', 'рыжая');
$cat2 = new Cat('Снежок', 'белая');

// Вывод: "Привет! Меня зовут Мурка. Я рыжая кошка."
echo $cat1->sayHello() . PHP_EOL;
// Вывод: "Привет! Меня зовут Снежок. Я белая кошка."
echo $cat2->sayHello() . PHP_EOL;
// Получаем цвет через геттер, прямой доступ к $cat1->color запрещён
echo 'Цвет Мурки: ' . $cat1->getColor() . PHP_EOL;
