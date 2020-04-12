<?php
//not PSR-2 compliant, commented
//declare(strict_types=1);

namespace WebApp\tests;

use PHPUnit\Framework\TestCase;

//autoloading not working
//require_once 'IProductTest.php';

class FurnitureTest extends TestCase implements IProductTest
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
    public function testCanBeInstantiatedWithValidConstructorArgs($sku, $name, $price, $dimensions)
    {
        //Arrange, Act
        $furniture = new Furniture($sku, $name, $price, $dimensions);

        //Assert - will/should constructor return a Doctrine DBAL Object?
        $this->isInstanceOf(Furniture::class, $furniture);
    }

    /**
    * Ensure Furniture constructor fails with invalid args
    * @dataProvider invalidConstructorArgumentProvider
    */
    public function testCannotBeInstantiatedWithInvalidConstructorArgs($sku, $name, $price, $dimensions, $exception)
    {
        //Assert
        $this->expectException($exception);

        //Arrange, Act
        $furniture = new Furniture($sku, $name, $price, $dimensions);
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
        $this->expectException(RangeException::class);

        //Arrange
        $furniture = new Furniture($sku, $name, $price, $dimensions);
        $furniture->setPrice(-5.0);
    }

    /**
    * Ensure that when appropriate method is used, a new ORM instance is correctly added to the corresponding database
    * @dataProvider validConstructorArgumentProvider
    */
    public function testProductIsAdded()
    {
        $this->markTestIncomplete('More knowledge of implementation of Doctrine DBAL models required');
    }

    /**
    * Ensure that when appropriate method is called the ORM object is removed from the database
    * @dataProvider validConstructorArgumentProvider
    */
    public function testProductIsRemoved()
    {
        $this->markTestIncomplete('More knowledge of implementation of Doctrine DBAL models required');
    }

    /**
    * This producer gives valid constructor args
    */
    public function validConstructorArgumentProvider()
    {
        return [
            ["TBL11FN", "Table", 60.0, [120, 50, 70]],
            ["CBN33FN", "Cabinet", 70.0, [60, 120, 210]],
            ["DSK5FN", "Desk", 55.0, [180, 70, 70]],
            ["PCT102FN", "Picture Frame", 13.0, [60, 40, 4]],
            ["LMP40FN", "Lamp Shade", 9.0, [40, 40, 25]]
        ];
    }

    /**
    * This producer gives constructor args followed by an expected exception type
    */
    public function invalidContructorArgumentProvider()
    {
        return [
            //SKU formatting error
            ["TBL011FN", "Table", 60.0, [120, 50, 70], ],
            //Invalid number of arguments
            ["CBN33FN", 70.0, [60, 120, 210], ArgumentCountError::class],
            //SKU formatting error
            ["DSK5DV", "Desk", 55.0, [180, 70, 70], ],
            //Giving price in incorrect format
            ["PCT102FN", "Picture Frame", "13.0", [60, 40, 4], TypeError::class],
            //Dimensions in invalid format
            ["LMP40FN", "Lamp Shade", 9.0, [4], LengthException::class]
        ];
    }
}
