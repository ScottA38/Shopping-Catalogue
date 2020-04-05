<?php
declare(strict_types=1);

use PHPUnit\Framework\Testcase;

/**
* Abstract base Test class which outlines testing contract for classes implementing iProduct
*/
final abstract class iProductTest extends TestCase
{
    /**
    * Test that extended product can be created with valid arguments
    */
    abstract function testCanBeInstantiatedWithCorrectConstructorArgs();

    /**
    *Assert class constructor fails when given invalid arguments
    */
    abstract function testCannotBeInstantiatedWithIncorrectConstructorArgs();

    /**
    * Assert an instance of iProduct implementer compares SKU when evaluating equality with another iProduct implementer
    */
    abstract function testObjectsCompareSKU();


    abstract function testHasSKU();

    abstract function testHasName();

    abstract function testHasPrice();

    /**
    * Verify that upon appropriate method call an iProduct implementer is correctly removed from product database
    */
    abstract function testProductIsRemoved();

    /**
    * Verify that upon appropriate method call iProduct implementer is added to product db
    */
    abstract function testProductIsAdded();
}
