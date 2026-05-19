<?php

// Абстрактный класс — нельзя создать объект напрямую (new HumanAbstract запрещён)
// Содержит общую логику для всех людей и объявляет методы, которые обязан реализовать каждый наследник
abstract class HumanAbstract
{
    private string $name; // имя хранится в базовом классе, доступно через getName()

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    // Геттер — единственный способ получить имя извне, т.к. свойство приватное
    public function getName(): string
    {
        return $this->name;
    }

    // Абстрактные методы — каждый наследник ОБЯЗАН их реализовать, иначе ошибка
    abstract public function getGreetings(): string;  // возвращает приветствие
    abstract public function getMyNameIs(): string;   // возвращает фразу "меня зовут"

    // Шаблонный метод — собирает итоговую фразу из абстрактных методов
    // Результат: "Привет! Меня зовут Иван."
    public function introduceYourself(): string
    {
        return $this->getGreetings() . '! ' . $this->getMyNameIs() . ' ' . $this->getName() . '.';
    }
}

// Наследник для русскоязычного человека — реализует оба абстрактных метода на русском
class RussianHuman extends HumanAbstract
{
    public function getGreetings(): string
    {
        return 'Привет';
    }

    public function getMyNameIs(): string
    {
        return 'Меня зовут';
    }
}

// Наследник для англоязычного человека — реализует те же методы, но на английском
class EnglishHuman extends HumanAbstract
{
    public function getGreetings(): string
    {
        return 'Hello';
    }

    public function getMyNameIs(): string
    {
        return 'My name is';
    }
}

$russian = new RussianHuman('Иван');
$english = new EnglishHuman('John');

// Вывод: "Привет! Меня зовут Иван."
echo $russian->introduceYourself() . PHP_EOL;
// Вывод: "Hello! My name is John."
echo $english->introduceYourself() . PHP_EOL;
