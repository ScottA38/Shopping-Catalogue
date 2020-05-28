<?php

declare(strict_types=1);

namespace WebApp\Controllers;

use WebApp\Models\Product;

/**
 * Basic interface to cover the core functionality a product Controller should implement
 */
interface IProductController
{
    public function add(string $name, float $price, $special): string;

    public function remove(string $sku): Product;

    public function removeAll(): array;

    public function updatePrice(string $sku, float $price): void;

    public function get(string $sku): Product;

    public function getAll(): array;

    public function getFieldMap(): array;
}
