<?php

declare(strict_types=1);

namespace WebApp\Tests;

use PHPUnit\Framework\TestCase;
use WebApp\Controllers\FurnitureController;
use WebApp\Models\Furniture;
//bootstraps doctrine entityManager
use WebApp\Bootstrap;

class FurnitureControllerTest extends TestCase implements IProductControllerTest
{

    protected ?FurnitureController $furnitureController;


    protected function setUp(): void
    {
        parent::setUp();

        $this->furnitureController = new FurnitureController();
    }

    /**
     * {@inheritDoc}
     * @see \WebApp\Models\IProductControllerTest::testAddProduct()
     * @dataProvider validFurnitureConstructorArgumentProvider
     */
    public function testAddProduct(string $name, float $price, array $dimensions)
    {
        //Arrange
        $furn = new Furniture($name, $price, $dimensions);
        //saving sku for later querying the database
        $sku = $furn->getSku();

        //Act
        $this->furnitureController->addProduct($furn);

        //Assert - query the database to see if product has been added
        $query = $em->createQuery("SELECT furn FROM WebApp\Model\Furniture furn WHERE furn.sku='{$sku}'");
        $result = $query->getResult();
    }

    private function validFurnitureConstructorArgumentProvider()
    {
        return FurnitureTest::validConstructorArgumentProvider();
    }

    private function invalidFurnitureConstructorArgumentProvider()
    {
        return FurnitureTest::invalidContructorArgumentProvider();
    }
}
