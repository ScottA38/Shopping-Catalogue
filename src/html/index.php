<?php

/**
 * A basic HTTP routing for each request of a user
 */

declare(strict_types=1);

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/':
        require __DIR__ . '/views/index.php';
        break;
    case ' ':
        require __DIR__ . 'views/index.php';
        break;
    case '/add_product':
        require __DIR__ . 'views/new_product.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . 'views/404.php';
}
