<?php

declare(strict_types=1);

namespace WebApp\Tests\Models;

use PHPUnit\Framework\TestCase;
use WebApp\Models\Product;

abstract class ProductTest extends TestCase
{
    /**
     * mock the id number in the class in order to make SKU-related functions work
     * @param Furniture
     */
    public static function seedId(Product $obj)
    {
        $refCls = new \ReflectionObject($obj);
        $refProp = $refCls->getProperty('sku');
        $refProp->setAccessible(true);
        $refProp->setValue($obj, random_int(0, 1200));
    }

    abstract public function testCanBeInstantiatedWithValidConstructorArgs($name, $price, $special);

    abstract public function testCannotBeInstantiatedWithInvalidArgs($name, $price, $special, $exception);

    abstract public function validConstructorArgumentProvider();

    abstract public function invalidConstructorArgumentProvider();
}
