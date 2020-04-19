<?php

declare(strict_types=1);

namespace WebApp\Tests;

use PHPUnit\Framework\TestCase;
use WebApp\Models\Furniture;

class FurnitureTest extends TestCase implements iProductTest
{

    protected array $furniture = [];

    /**
    * Instantiate an instances of Furniture for use with test methods
    */
    protected function setUp(): void
    {
        $this->furniture = [];

        $args = $this->validConstructorArgumentProvider();

        for ($i = 0; $i < count($args); $i++) {
            array_push($this->furniture, $args[$i]);
        }
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
    * @dataProvider instanceProvider
    */
    public function testEquals(Furniture $obj)
    {
        //Arrange
        $dataProvider = $this->validConstructorArgumentProvider()[0];
        $furnitureTwo = new Furniture($dataProvider[0], $dataProvider[1], $dataProvider[2]);

        //Assert
        $this->assertThat($obj, $this->logicalNot($this->equalTo($furnitureTwo)));
    }

    /**
    * Tests for attribute of SKU
    * @dataProvider instanceProvider
    */
    public function testHasSKU(Furniture $obj)
    {
        //Assert
        $this->assertObjectHasAttribute('sku', $obj);
    }

    /**
    * Tests for attribute of name
    * @dataProvider instanceProvider
    */
    public function testHasName(Furniture $obj)
    {
        //Assert
        $this->assertObjectHasAttribute('name', $obj);
    }

    /**
    * Tests for attribute of price
    * @dataProvider instanceProvider
    */
    public function testHasPrice(Furniture $obj)
    {
        //Assert
        $this->assertObjectHasAttribute('price', $obj);
    }

    /**
    * Tests for attribute of Dimensions
    * @dataProvider instanceProvider
    */
    public function testHasDimensions(Furniture $obj)
    {
        $this->assertObjectHasAttribute('dimensions', $obj);
    }

    /**
    * Assert dimension attribute is an array of length 3
    * @dataProvider instanceProvider
    */
    public function testDimensionsAttributeIsAThreeItemArray(Furniture $obj)
    {
        //Assert
        $this->assertIsArray($obj->getDimensions());

        $dimensionCount = count($obj->getDimensions());
        $this->assertEquals(3, $dimensionCount);
    }

    /**
    * Call price update function and assert that new price is set in object
    * @dataProvider instanceProvider
    */
    public function testPriceCanBeUpdated(Furniture $obj)
    {
        //generate random price to update price attribute to
        $new_price = (float)random_int(0, PHP_INT_MAX);
        $obj->setPrice($new_price);

        //Assert
        $this->assertEqual($new_price, $obj->getPrice());
    }

    /**
     *Tests that price cattirbute cannot be set as negative
     *@dataProvider instanceProvider
     */
    public function testPriceCannotBeANegativeValue(Furniture $obj)
    {
        //Assert
        $this->expectException(\RangeException::class);

        //Arrange
        $obj->setPrice(-5.0);
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

    /**
     * Test method to generate test subject instances
     */
    public function instanceProvider()
    {
        assert($this->furniture !== null);
        return $this->furniture;
    }
}
