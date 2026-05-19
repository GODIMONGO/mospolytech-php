<?php

namespace Controllers;

class HomeController
{
    public function sayHello(string $name): void
    {
        render('hello', ['title' => 'Страница приветствия', 'name' => $name]);
    }

    public function sayBye(string $name): void
    {
        render('bye', ['name' => $name]); // title не передан — layout подставит "Мой блог"
    }
}
