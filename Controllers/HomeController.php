<?php

namespace Controllers;

class HomeController
{
    public function sayHello(string $name): void
    {
        echo "Привет, $name";
    }

    public function sayBye(string $name): void
    {
        echo "Пока, $name";
    }
}
