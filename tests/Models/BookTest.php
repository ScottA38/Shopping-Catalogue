<?php

declare(strict_types=1);

namespace WebApp\Tests\Models;

use WebApp\Models\Book;

/**
 * Testing unique content of Book class
 * (assume Furniture tests base class logic required by IProductTest)
 * @author ScottAnderson
 *
 */
class BookTest extends ProductTest
{
    protected Book $book;

    public function setUp(): void
    {
        parent::setUp();
        $args = $this->getProvidedData();

        $this->book = new Book(...$args);

        $this->seedId($this->book);
    }

    public function testHasWeightAttribute()
    {
        $this->assertClassHasAttribute('weight', get_class($this->book));
    }

    public function testCannotChangeWeight()
    {
        $refCls = new \ReflectionObject($this->book);
        $refProp = $refCls->getProperty('weight');

        $this->assertFalse($refProp->isPublic());
        $this->assertClassNotHasAttribute('setWeight', get_class($this->book));
    }

    /**
     * Ensure correct instantiation
     *  @dataProvider validConstructorArgumentProvider
     */
    public function testCanBeInstantiatedWithValidConstructorArgs($name, $price, $weight)
    {
        $book = new Book($name, $price, $weight);

        $this->assertInstanceOf(Book::class, $book);
    }

    /**
     * {@inheritDoc}
     * @see \WebApp\Tests\ProductTest::testCannotBeInstantiatedWithInvalidArgs()
     * @dataProvider invalidConstructorArgumentProvider
     */
    public function testCannotBeInstantiatedWithInvalidArgs($name, $price, $weight, $exception)
    {
        $this->expectException($exception);

        new Book($name, $price, $weight);
    }

    public function validConstructorArgumentProvider()
    {
        return [
            ["Harry Potter: Wizard Boyy", 14.0, 2.1],
            ["Spy guy", 8.20, 0.5],
            ["The book of silly wobbles", 4.10, 6.0],
            ["Terry's grand expedition", 30.0, 0.1]
        ];
    }

    public function invalidConstructorArgumentProvider()
    {
        return [
            [40, 14.0, 2.1, 'TypeError'],
            ["Spy guy", 8.20, -1.1, 'Exception'],
            ["The book of silly wobbles", 4.10, "7.0", 'TypeError'],
        ];
    }
}
