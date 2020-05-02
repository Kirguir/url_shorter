<?php


namespace App;


class Controller
{
    protected function render(string $view, array $data = []): void
    {
        extract($data);
        include 'View/layout.php';
        exit();
    }
}