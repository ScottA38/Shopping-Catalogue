<?php

declare(strict_types=1);

namespace WebApp\Controllers;

/**
 * Basic interface to cover the core functionality a product Controller should implement
 */
interface IProductController
{
    public function add(string $name, float $price, $special): string;

    public function remove(string $sku): void;

    public function removeAll(): array;

    public function updatePrice(string $sku, float $price): void;
}
