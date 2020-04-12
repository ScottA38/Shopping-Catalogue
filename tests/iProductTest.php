<?php
//not PSR-2 compliant, commented
//declare(strict_types=1);

namespace WebApp\Tests;

/**
* Abstract base Test class which outlines testing contract for classes implementing iProduct
*/
interface IProductTest
{
    /**
    * Test that extended product can be created with valid arguments.
    * N.B: The 'special' attribute refers to an additional argument expected for each implementor of
    */
    public function testCanBeInstantiatedWithValidConstructorArgs($sku, $name, $price, $special);

    /**
    *Assert class constructor fails when given invalid arguments
    */
    public function testCannotBeInstantiatedWithInValidConstructorArgs($sku, $name, $price, $special, $exception);

    /**
    * Test objects of identical arguments do not compare equal
    */
    public function testEquals();

    /**
    * Tests for attribute of SKU
    */
    public function testHasSKU();

    /**
    * Tests for attribute of name
    */
    public function testHasName();

    /**
    * Tests for attribute of price
    */
    public function testHasPrice();

    /**
    * Tests that price updates correctly
    */
    public function testPriceCanBeUpdated();

    /**
    * Tests that price cannot be set to below 0
    */
    public function testPriceCannotBeANegativeValue();

    /**
    * Verify that upon appropriate method call an iProduct implementer is correctly removed from product database
    */
    public function testProductIsRemoved();

    /**
    * Verify that upon appropriate method call iProduct implementer is added to product db
    */
    public function testProductIsAdded();
}
