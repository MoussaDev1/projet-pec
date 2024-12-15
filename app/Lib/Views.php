<?php

namespace App\Lib;

class Views
{
    public static function render(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        include __DIR__ . '/../views/templates/header.php';
        include __DIR__ . '/../views/' . $view . '.php';
        include __DIR__ . '/../views/templates/footer.php';
    }
}
