<?php

declare(strict_types=1);

namespace WebApp\Tests\Controllers;

use PHPUnit\Framework\TestCase;
use WebApp\Controllers\FurnitureController;
use WebApp\Models\Furniture;
use WebApp\Util\EntityPopulator;
//bootstraps doctrine entityManager
use WebApp\Bootstrap;
use Doctrine\ORM\EntityManager;

class FurnitureControllerTest extends TestCase implements IProductControllerTest
{

    protected FurnitureController $furnitureController;

    //protected static EntityPopulator $entityPopulator;

    protected static EntityManager $em;


    public static function setUpBeforeClass(): void
    {
        $dbParams = array('url' => "mysql://dev_admin:p455w0rd@127.0.0.1:3306/my_db");
        $bootstrap = new Bootstrap();
        FurnitureControllerTest::$em = $bootstrap->createEntityManager($dbParams);
        //pre-populate the database with records
        $populator = new EntityPopulator(FurnitureControllerTest::$em);
        $populator->populate(Furniture::class, 10);
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

        //Act
        $id = $this->furnitureController->add($furn);

        //Assert - query the database to see if product has been added
        $repo = FurnitureControllerTest::$em->getRepository(Furniture::class);
        $this->assertIsObject($repo->find($id));
    }

    /**
     *
     * {@inheritDoc}
     * @see \WebApp\Tests\Controllers\IProductControllerTest::testRemoveProduct()
     */
    public function testRemoveProduct(string $sku)
    {
        //Act
        $this->furnitureController->remove($sku);

        //Assert
        $this->assertTrue(FurnitureControllerTest::$em->find($sku) === null);
    }

    /**
     * {@inheritDoc}
     * @see \WebApp\Tests\Controllers\IProductControllerTest::testRemoveAllProducts()
     */
    public function testRemoveAllProducts()
    {
        //Act
        $this->furnitureController->removeAll();

        //Assert
        $repo = FurnitureControllerTest::$em->getRespository(Furniture::class);
        $this->assertCount(0, $repo->findAll());
    }

    /**
     * {@inheritDoc}
     * @see \WebApp\Tests\Controllers\IProductControllerTest::testUpdatePrice()
     */
    public function testUpdatePrice(string $sku, float $price)
    {
        //Act
        $this->furnitureController->updatePrice($sku, $price);

        //Assert
        $this->assertEquals($price, FurnitureControllerTest::$em->find($sku)->getPrice());
    }
}
