<?php

declare(strict_types=1);

namespace WebApp\Tests\Controllers;

use PHPUnit\Framework\TestCase;
use WebApp\Controllers\FurnitureController;
use WebApp\Models\Furniture;
use WebApp\Tests\Models\FurnitureTest;
//bootstraps doctrine entityManager
use WebApp\Bootstrap;
use Doctrine\ORM\EntityManager;

class FurnitureControllerTest extends TestCase implements IProductControllerTest
{

    protected ?FurnitureController $furnitureController;

    protected static ?EntityManager $em;


    public static function setUpBeforeClass(): void
    {
        $bootstrap = Bootstrap::getInstance();
        //extract EntityManager from Bootstrap instance
        FurnitureControllerTest::$em = $bootstrap->getEntityManager();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->furnitureController = new FurnitureController();
    }

    /**
     * {@inheritDoc}
     * @see \WebApp\Tests\Controllers\IProductControllerTest::testAddProduct()
     * @dataProvider validFurnitureConstructorArgumentProvider
     */
    public function testAddProduct(string $name, float $price, $dimensions)
    {
        //Arrange
        $furn = new Furniture($name, $price, $dimensions);
        //saving sku for later querying the database
        $sku = $furn->getSku();

        //Act
        $this->furnitureController->addProduct($furn);

        //Assert - query the database to see if product has been added
        $query = Bootstrap::$em->createQuery("SELECT furn FROM WebApp\Model\Furniture furn WHERE furn.sku='{$sku}'");
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
