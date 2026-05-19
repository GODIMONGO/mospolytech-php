<?php

// Базовый класс — описывает обычный (бесплатный) урок
class Lesson
{
    private string $title;    // заголовок урока
    private string $text;     // текст урока
    private string $homework; // домашнее задание

    public function __construct(string $title, string $text, string $homework)
    {
        $this->title    = $title;
        $this->text     = $text;
        $this->homework = $homework;
    }

    // Геттеры — позволяют читать приватные свойства извне
    public function getTitle(): string    { return $this->title; }
    public function getText(): string     { return $this->text; }
    public function getHomework(): string { return $this->homework; }

    // Сеттеры — позволяют изменять свойства через метод, а не напрямую
    public function setTitle(string $title): void { $this->title    = $title; }
    public function setText(string $text): void   { $this->text     = $text; }
    public function setHomework(string $hw): void { $this->homework = $hw; }
}

// Наследник — платный урок, расширяет Lesson новым свойством price
// Наследует все свойства и методы родителя, добавляет своё
class PaidLesson extends Lesson
{
    private float $price; // цена урока

    public function __construct(string $title, string $text, string $homework, float $price)
    {
        // Вызываем конструктор родителя, чтобы инициализировать его свойства
        parent::__construct($title, $text, $homework);
        $this->price = $price;
    }

    public function getPrice(): float        { return $this->price; }
    public function setPrice(float $p): void { $this->price = $p; }
}

$lesson = new PaidLesson(
    'Урок о наследовании в PHP',
    'Лол, кек, чебурек',
    'Ложитесь спать, утро вечера мудренее',
    99.90
);

// var_dump выводит полную структуру объекта: класс, все свойства и их значения
var_dump($lesson);
