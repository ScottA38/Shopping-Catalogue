<?php

declare(strict_types=1);

namespace WebApp\Tests\Models;

use WebApp\Models\Novel;

/**
 * Testing unique content of Book class
 * (assume Furniture tests base class logic required by IProductTest)
 * @author ScottAnderson
 *
 */
class NovelTest extends ProductTest
{
    protected ?Novel $novel;

    public function setUp(): void
    {
        parent::setUp();
        $args = $this->getProvidedData();

        if (count($args) === 3) {
            $this->novel = new Novel(...$args);
            self::$em->persist($this->novel);
            self::$em->flush();
        } else {
            $this->novel = null;
        }
    }

    /**
     * @dataProvider validConstructorArgumentProvider
     */
    public function testHasWeightAttribute()
    {
        $this->assertClassHasAttribute('weight', get_class($this->novel));
    }

    /**
     * @dataProvider validConstructorArgumentProvider
     */
    public function testCannotChangeWeight()
    {
        $refCls = new \ReflectionObject($this->novel);
        $refProp = $refCls->getProperty('weight');

        $this->assertFalse($refProp->isPublic());
        $this->assertClassNotHasAttribute('setWeight', get_class($this->novel));
    }

    /**
     * Ensure correct instantiation
     *  @dataProvider validConstructorArgumentProvider
     */
    public function testCanBeInstantiatedWithValidConstructorArgs($name, $price, $weight)
    {
        $book = new Novel($name, $price, $weight);

        $this->assertInstanceOf(Novel::class, $book);
    }

    /**
     * {@inheritDoc}
     * @see \WebApp\Tests\ProductTest::testCannotBeInstantiatedWithInvalidArgs()
     * @dataProvider invalidConstructorArgumentProvider
     */
    public function testCannotBeInstantiatedWithInvalidArgs($name, $price, $weight, $exception)
    {
        $this->expectException($exception);

        new Novel($name, $price, $weight);
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
