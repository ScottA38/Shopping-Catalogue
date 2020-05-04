<?php

declare(strict_types=1);

namespace WebApp\Tests\Models;

use PHPUnit\Framework\TestCase;
use WebApp\Models\Furniture;

class FurnitureTest extends TestCase implements IProductTest
{

    protected ?Furniture $furniture;

    /**
    * Instantiate an instances of Furniture for use with test methods
    */
    protected function setUp(): void
    {
        parent::setUp();
        $args = $this->getProvidedData();
        //var_dump($args);

        if (count($args) !== 3) {
            $this->furniture = null;
        } else {
            $this->furniture = new Furniture(...$args);
            $this->seedId($this->furniture);
        }
    }

    /**
    * Ensure Furniture constructor creates instance with valid args
    * @dataProvider validConstructorArgumentProvider
    */
    public function testCanBeInstantiatedWithValidConstructorArgs(string $name, float $price, array $dimensions)
    {
        //Arrange, Act
        $furniture = new Furniture($name, $price, $dimensions);

        //Assert - will/should constructor return a Doctrine DBAL Object?
        $this->assertInstanceOf(Furniture::class, $furniture);
    }

    /**
    * Ensure Furniture constructor fails with invalid args
    * @dataProvider invalidContructorArgumentProvider
    */
    public function testCannotBeInstantiatedWithInvalidArgs($name, $price, $dimensions, $exception)
    {
        //Assert
        $this->expectException($exception);

        //Arrange, Act
        new Furniture($name, $price, $dimensions);
    }

    /**
    * Test that 2 instances with identical data are not considered equal
    * @dataProvider validConstructorArgumentProvider
    */
    public function testEquals(string $name, float $price, array $dimensions)
    {
        //Arrange
        $dataProvider = $this->validConstructorArgumentProvider()[0];
        $furnitureTwo = new Furniture($dataProvider[0], $dataProvider[1], $dataProvider[2]);
        //seed a random Id number in order to test SKU-related functionality
        $this::seedId($furnitureTwo);

        //Assert
        $this->assertTrue(!$this->furniture->compareTo($furnitureTwo));
    }

    /**
    * Tests for attribute of SKU
    * @dataProvider validConstructorArgumentProvider
    */
    public function testHasSKU()
    {
        //Assert
        $this->assertTrue(method_exists($this->furniture, 'getSku'));
    }

    /**
     * Tests that SKU format provided by object is correct
     * @dataProvider validConstructorArgumentProvider
     */
    public function testSKUIsProvidedInCorrectFormat()
    {
        //Assert
        $this->assertMatchesRegularExpression('/[A-Z]{3}\d+FR/', $this->furniture->getSku());
    }

    /**
    * Tests for attribute of name
    * @dataProvider validConstructorArgumentProvider
    */
    public function testHasName()
    {
        //Assert
        $this->assertObjectHasAttribute('name', $this->furniture);
    }

    /**
    * Tests for attribute of price
    * @dataProvider validConstructorArgumentProvider
    */
    public function testHasPrice()
    {
        //Assert
        $this->assertObjectHasAttribute('price', $this->furniture);
    }

    /**
    * Tests for attribute of Dimensions
    * @dataProvider validConstructorArgumentProvider
    */
    public function testHasDimensions()
    {
        $this->assertObjectHasAttribute('dimensions', $this->furniture);
    }

    /**
    * Assert dimension attribute is an array of length 3
    * @dataProvider validConstructorArgumentProvider
    */
    public function testDimensionsAttributeIsAThreeItemArray()
    {
        //Assert
        $this->assertIsArray($this->furniture->getDimensions());

        $dimensionCount = count($this->furniture->getDimensions());
        $this->assertEquals(3, $dimensionCount);
    }

    /**
    * Call price update function and assert that new price is set in object
    * @dataProvider validConstructorArgumentProvider
    */
    public function testPriceCanBeUpdated()
    {
        //generate random price to update price attribute to
        $new_price = (float)random_int(0, PHP_INT_MAX);
        $this->furniture->setPrice($new_price);

        //Assert
        $this->assertEquals($new_price, $this->furniture->getPrice());
    }

    /**
     *Tests that price cattirbute cannot be set as negative
     *@dataProvider validConstructorArgumentProvider
     */
    public function testPriceCannotBeANegativeValue()
    {
        //Assert
        $this->expectException(\RangeException::class);

        //Arrange
        $this->furniture->setPrice(-5.0);
    }

    /**
    * This producer gives valid constructor args
    */
    public static function validConstructorArgumentProvider()
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
    public static function invalidContructorArgumentProvider()
    {
        return [
            //Invalid product name (must have more than 2 consonants in the string)
            ["It", 60.0, [120, 50, 70], 'LengthException'],
            //Invalid number of arguments
            //[70.0, [60, 120, 210], \ArgumentCountError::class],
            //SKU formatting error
            ["Desk", -10.0, [180, 70, 70], 'RangeException'],
            //Giving price in incorrect format
            ["Picture Frame", "13.0", [60, 40, 4], 'TypeError'],
            //Dimensions in invalid format
            ["Lamp Shade", 9.0, [4], 'LengthException']
        ];
    }


    /**
     * mock the id number in the class in order to make SKU-related functions work
     * @param Furniture
     */
    public static function seedId(Furniture $obj)
    {
        $refCls = new \ReflectionObject($obj);
        $refProp = $refCls->getProperty('id');
        $refProp->setAccessible(true);
        $refProp->setValue($obj, random_int(0, 1200));
    }
}
