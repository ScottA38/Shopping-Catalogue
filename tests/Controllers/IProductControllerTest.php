<?php

declare(strict_types=1);

namespace WebApp\Tests\Controllers;

/**
 * Interface outlining basic testing contract for classes inheriting 'ProductController' base class
 *
 */
interface IProductControllerTest
{

    /**
     * Product can be added to database successfully
     */
    public function testAddProduct(string $name, float $price, $special);

    /**
     * Product can be removed from database successfully and cleanly
     */
    public function testRemoveProduct();


    /**
     * All products can be removed from the database
     */
    public function testRemoveAllProducts();

    /**
     * The user can update the price of a specific product
     * @param mixed $sku
     */
    public function testUpdatePrice($sku);
}
