<?php

declare(strict_types=1);

namespace WebApp\Tests;

use WebApp\Models\Furniture;

/**
* Abstract base Test class which outlines testing contract for classes implementing iProduct
*/
interface IProductTest
{
    /**
    * Test t    hat extended product can be created with valid arguments.
    * N.B: The 'special' attribute refers to an additional argument expected for each implementor of
    */
    public function testCanBeInstantiatedWithValidConstructorArgs(string $name, float $price, array $special);

    /**
    *Assert class constructor fails when given invalid arguments
    */
    public function testCannotBeInstantiatedWithInValidArgs(string $name, float $price, array $special, $exception);

    /**
    * Test objects of identical arguments do not compare equal
    * @param Furniture
    */
    public function testEquals(Furniture $obj);

    /**
    * Tests for attribute of SKU
    * @param Furniture
    */
    public function testHasSKU(Furniture $obj);

    /**
    * Tests for attribute of name
    * @param Furniture
    */
    public function testHasName(Furniture $obj);

    /**
    * Tests for attribute of price
    * @param Furniture
    */
    public function testHasPrice(Furniture $obj);

    /**
    * Tests that price updates correctly
    * @param Furniture
    */
    public function testPriceCanBeUpdated(Furniture $obj);

    /**
    * Tests that price cannot be set to below
    * @param Furniture
    */
    public function testPriceCannotBeANegativeValue(Furniture $obj);
}
