<?php

declare(strict_types=1);

namespace WebApp\Tests\Models;

use WebApp\Models\DVDDisc;

class DVDDiscTest extends ProductTest
{
    protected ?DVDDisc $disc;

    protected function setUp(): void
    {
        parent::setUp();
        $args = $this->getProvidedData();
        //var_dump($args);

        if (count($args) !== 3) {
            $this->disc = null;
            return;
        }
        $this->disc = new DVDDisc(...$args);

        $this->seedId($this->disc);
    }

    /**
     * {@inheritDoc}
     * @see \WebApp\Tests\Models\ProductTest::testCanBeInstantiatedWithValidConstructorArgs()
     * @dataProvider validConstructorArgumentProvider
     */
    public function testCanBeInstantiatedWithValidConstructorArgs($name, $price, $size)
    {
        $disc = new DVDDisc($name, $price, $size);

        $this->assertInstanceOf(DVDDisc::class, $disc);
    }

    /**
     * {@inheritDoc}
     * @see \WebApp\Tests\Models\ProductTest::testCannotBeInstantiatedWithInvalidArgs()
     * @dataProvider invalidConstructorArgumentProvider
     */
    public function testCannotBeInstantiatedWithInvalidArgs($name, $price, $size, $exception)
    {
        $this->expectException($exception);

        new DVDDisc($name, $price, $size);
    }

    /**
     * @dataProvider validConstructorArgumentProvider
     */
    public function testHasSizeAttribute()
    {
        $this->assertClassHasAttribute('size', get_class($this->disc));
    }

    public function validConstructorArgumentProvider()
    {
        return [
            ["Risk: the film", 15.0, 2048],
            ["Fido's lost bone: the sequel", 5.0, 400],
            ["Carcassone", 20.0, 4096],
            ["Kerijas dienasgramata", 7.0, 300]
        ];
    }

    public function invalidConstructorArgumentProvider()
    {
        return [
            [50, 15.0, 2048, \TypeError::class],
            ["Fido's lost bone: the sequel", 5.0, 400.1, \TypeError::class],
            ["Carcassone", 20.0, "Thing", \TypeError::class],
            ["MSI investigators", 4.0, -5, \RangeException::class]
        ];
    }
}
