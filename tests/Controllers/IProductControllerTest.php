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
     * Product can be removed from database successfully and cleanly. Should select from
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
    public function testUpdatePrice();

    /**
     * Test that can search for and return a specific sku
     * @return array
     */
    public function testShowOne();
    /**
     * test that can return all entities of the controller type
     * @return array
     */
    public function testShowAll();
}
