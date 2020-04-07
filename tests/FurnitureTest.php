<?php
//not PSR-2 compliant, commented
//declare(strict_types=1);

namespace WebApp\tests;

use PHPUnit\Framework\TestCase;
use WebApp\Tests;

class FurnitureTest extends TestCase implements iProductTest
{

    protected $furniture;

    /**
    * Instantiate an instance of Furniture for use with all test methods not involved with class constructor objectives
    * @dataProvider validConstructorArgumentProvider
    */
    protected function setUp($sku, $name, $price, $dimensions) : void
    {
        $this->furniture = new Furniture($sku, $name, $price, $dimensions);
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
    */
    public function testEquals()
    {
        //Arrange
        $furnitureTwo = new Furniture($sku, $name, $price, $dimensions);

        //Assert
        $this->assertThat($this->furniture, $this->logicalNot($this->equalTo($furnitureTwo)));
    }

    /**
    * Tests for attribute of SKU
    */
    public function testHasSKU()
    {
        $this->assertObjectHasAttribute('sku', $this->furniture);
    }

    /**
    * Tests for attribute of name
    */
    public function testHasName()
    {
        $this->assertObjectHasAttribute('name', $this->furniture);
    }

    /**
    * Tests for attribute of price
    */
    public function testHasPrice()
    {
        $this->assertObjectHasAttribute('price', $this->furniture);
    }

    /**
    * Tests for attribute of Dimensions
    */
    public function testHasDimensions()
    {
        $this->assertObjectHasAttribute('dimensions', $this->furniture);
    }

    /**
    * Test that dimension attribute is an array of length 3
    */
    public function testDimensionsAttributeIsAThreeItemArray()
    {
        $this->assertIsArray($this->furniture->dimensions);
        $dimensionCount = count($this->furniture->dimensions);
        $this->assertEquals(3, $dimensionCount);
    }

    public function testProductIsAdded()
    {
        $this->markTestIncomplete('More knowledge of implementation of Doctrine DBAL models required');
    }

    public function testProductIsRemoved()
    {
        $this->markTestIncomplete('More knowledge of implementation of Doctrine DBAL models required');
    }

    /**
    * This producer gives valid constructor args
    */
    private function validConstructorArgumentProvider()
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
    private function invalidContructorArgumentProvider()
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
