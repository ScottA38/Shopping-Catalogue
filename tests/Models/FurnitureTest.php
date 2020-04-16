<?php
//not PSR-2 compliant, commented
//declare(strict_types=1);

namespace WebApp\Tests;

use PHPUnit\Framework\TestCase;
use WebApp\Models\Furniture;


class FurnitureTest extends TestCase implements iProductTest
{

    //protected $furniture;

    /**
    * Instantiate an instance of Furniture for use with all test methods not involved with class constructor objectives
    * @dataProvider validConstructorArgumentProvider
    */
    protected function setUp() : void
    {
        /*parent::setUp();
        $arguments = $this->getProvidedData($this->validConstructorArgumentProvider);
        echo count($arguments);*/
    }

    /**
    * Ensure Furniture constructor creates instance with valid args
    * @dataProvider validConstructorArgumentProvider
    */
    public function testCanBeInstantiatedWithValidConstructorArgs($name, $price, $dimensions)
    {
        //Arrange, Act
        $furniture = new Furniture($name, $price, $dimensions);

        //Assert - will/should constructor return a Doctrine DBAL Object?
        $this->isInstanceOf(Furniture::class, $furniture);
    }

    /**
    * Ensure Furniture constructor fails with invalid args
    * @dataProvider invalidConstructorArgumentProvider
    */
    public function testCannotBeInstantiatedWithInvalidConstructorArgs($name, $price, $dimensions, $exception)
    {
        //Assert
        $this->expectException($exception);

        //Arrange, Act
        $furniture = new Furniture($name, $price, $dimensions);
    }

    /**
    * Test that 2 instances with identical data are not considered equal
    * @dataProvider validConstructorArgumentProvider
    */
    public function testEquals()
    {
        //Arrange
        $furniture = new Furniture($sku, $name, $price, $dimensions);
        $furnitureTwo = new Furniture($sku, $name, $price, $dimensions);

        //Assert
        $this->assertThat($furniture, $this->logicalNot($this->equalTo($furnitureTwo)));
    }

    /**
    * Tests for attribute of SKU
    * @dataProvider validConstructorArgumentProvider
    */
    public function testHasSKU()
    {
        //Arrange
        $furniture = new Furniture($sku, $name, $price, $dimensions);

        //Assert
        $this->assertObjectHasAttribute('sku', $furniture);
    }

    /**
    * Tests for attribute of name
    * @dataProvider validConstructorArgumentProvider
    */
    public function testHasName()
    {
        //Arrange
        $furniture = new Furniture($sku, $name, $price, $dimensions);

        //Assert
        $this->assertObjectHasAttribute('name', $furniture);
    }

    /**
    * Tests for attribute of price
    * @dataProvider validConstructorArgumentProvider
    */
    public function testHasPrice()
    {
        //Arrange
        $furniture = new Furniture($sku, $name, $price, $dimensions);

        //Assert
        $this->assertObjectHasAttribute('price', $furniture);
    }

    /**
    * Tests for attribute of Dimensions
    * @dataProvider validConstructorArgumentProvider
    */
    public function testHasDimensions()
    {
        //Arrange
        $furniture = new Furniture($sku, $name, $price, $dimensions);

        $this->assertObjectHasAttribute('dimensions', $furniture);
    }

    /**
    * Assert dimension attribute is an array of length 3
    * @dataProvider validConstructorArgumentProvider
    */
    public function testDimensionsAttributeIsAThreeItemArray()
    {
        //Arrange
        $furniture = new Furniture($sku, $name, $price, $dimensions);

        //Assert
        $this->assertIsArray($furniture->getDimensions());

        $dimensionCount = count($furniture->getDimensions());
        $this->assertEquals(3, $dimensionCount);
    }

    /**
    * Call price update function and assert that new price is set in object
    */
    public function testPriceCanBeUpdated()
    {
        //Arrange
        $furniture = new Furniture($sku, $name, $price, $dimensions);

        //Act
        $new_price = $furniture->getPrice * (float)random_int(0, PHP_INT_MAX);
        $furniture->setPrice($new_price);

        //Assert
        $this->assertEqual($new_price, $furniture->getPrice());
    }

    public function testPriceCannotBeANegativeValue()
    {
        //Assert
        $this->expectException(\RangeException::class);

        //Arrange
        $furniture = new Furniture($sku, $name, $price, $dimensions);
        $furniture->setPrice(-5.0);
    }

    /**
    * This producer gives valid constructor args
    */
    public function validConstructorArgumentProvider()
    {
        return [
            ["Table", 60.0, [120, 50, 70]],
            ["Cabinet", 70.0, [60, 120, 210]],
            ["Desk", 55.0, [180, 70, 70]],
            ["Picture Frame", 13.0, [60, 40, 4]],
            ["Lamp Shade", 9.0, [40, 40, 25]]
        ];
    }

    /**
    * This producer gives constructor args followed by an expected exception type
    */
    public function invalidContructorArgumentProvider()
    {
        return [
            //Invalid product name (must have more than 2 consonants in the string)
            ["It", 60.0, [120, 50, 70], \AssertionError::class],
            //Invalid number of arguments
            [70.0, [60, 120, 210], \ArgumentCountError::class],
            //SKU formatting error
            ["Desk", -10.0, [180, 70, 70], \RangeException::class],
            //Giving price in incorrect format
            ["Picture Frame", "13.0", [60, 40, 4], \TypeError::class],
            //Dimensions in invalid format
            ["Lamp Shade", 9.0, [4], \LengthException::class]
        ];
    }
}
