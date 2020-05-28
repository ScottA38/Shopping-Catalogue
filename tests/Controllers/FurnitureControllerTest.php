<?php

declare(strict_types=1);

namespace WebApp\Tests\Controllers;

use PHPUnit\Framework\TestCase;
use WebApp\Controllers\FurnitureController;
use WebApp\Models\Furniture;
use WebApp\Tests\Models\FurnitureTest;
use WebApp\Util\ProductPopulator;
//bootstraps doctrine entityManager
use WebApp\Bootstrap;
use Doctrine\ORM\EntityManager;
use Faker\Factory;

class FurnitureControllerTest extends TestCase implements IProductControllerTest
{
    protected FurnitureController $furnitureController;

    protected array $pks;

    protected static EntityManager $em;

    private static array $dbParams = array('url' => "mysql://dev_admin:p455w0rd@127.0.0.1:3306/my_db");

    /**
     * set up a database connection in order to seed database for tests and verify test conditions
     */
    public static function setUpBeforeClass(): void
    {
        $bootstrap = new Bootstrap();
        self::$em = $bootstrap->createEntityManager(self::$dbParams);
    }

    public static function tearDownAfterClass(): void
    {
        self::$em->clear();
        self::$em->close();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->furnitureController = new FurnitureController(self::$em);

        //pre-populate the database with 10 records
        $populator = new ProductPopulator(self::$em);
        $this->pks = $populator->populate(Furniture::class, 10);
    }

    /**
     * Empty Furniture table again ready for fresh re-population
     * {@inheritDoc}
     * @see \PHPUnit\Framework\TestCase::tearDown()
     */
    protected function tearDown(): void
    {
        $className = Furniture::class;
        self::$em->createQuery("DELETE FROM $className")->execute();
        assert(count(self::$em->getRepository(Furniture::class)->findAll()) === 0);
    }

    /**
     * {@inheritDoc}
     * @see \WebApp\Tests\Controllers\IProductControllerTest::testAddProduct()
     * @dataProvider furnitureValidArgsProvider
     */
    public function testAddProduct(string $name, float $price, $dimensions)
    {
        //Act
        $id = $this->furnitureController->add($name, $price, $dimensions);

        //Assert - query the database to see if product has been added
        $repo = self::$em->getRepository(Furniture::class);
        $this->assertIsObject($repo->find($id));
    }

    /**
     *
     * {@inheritDoc}
     * @see \WebApp\Tests\Controllers\IProductControllerTest::testRemoveProduct()
     */
    public function testRemoveProduct()
    {
        //Arrange - subsitute for dataProvider
        $sku = $this->randomSkuProvider();

        //Act
        $this->furnitureController->remove($sku);

        //Assert
        $this->assertTrue(self::$em->find(Furniture::class, $sku) === null);
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
        $repo = self::$em->getRepository(Furniture::class);
        $this->assertCount(0, $repo->findAll());
    }

    /**
     * {@inheritDoc}
     * @see \WebApp\Tests\Controllers\IProductControllerTest::testUpdatePrice()
     */
    public function testUpdatePrice()
    {
        //Arrange
        $sku = $this->randomSkuProvider();
        $generator = Factory::create();
        $newPrice = $generator->randomNumber(5);

        //Act
        $this->furnitureController->updatePrice($sku, $newPrice);

        //Assert
        $this->assertEquals($newPrice, self::$em->find(Furniture::class, $sku)->getPrice());
    }

    public function testGetFieldMapping()
    {
        //Act
        $fieldMap = $this->furnitureController->getFieldMap();

        //Assert
        $this->assertArrayHasKey("sku", $fieldMap);
        $this->assertArrayHasKey("price", $fieldMap);
        $this->assertArrayHasKey("name", $fieldMap);
        $this->assertArrayHasKey("dimensions", $fieldMap);
    }

    /**
     * {@inheritDoc}
     * @see \WebApp\Tests\Controllers\IProductControllerTest::testShowOne()
     */
    public function testShowOne()
    {
        //Arrange
        $sku = $this->randomSkuProvider();

        //Act
        $obj = $this->furnitureController->get($sku);

        //Assert
        $this->assertInstanceOf(Furniture::class, $obj);
        $this->assertSame($sku, $obj->getSku());
    }

    public function testShowAll()
    {
        //Act
        $objs = $this->furnitureController->getAll();

        //Assert
        $this->assertCount(count($objs), self::$em->getRepository(Furniture::class)->findAll());
        //shortcut to testing member types of array
        $this->assertSame(Furniture::class, get_class($objs[0]));
    }

    /**
     * Ensures that class name returned is valid in ORM
     */
    public function testGetModelNameReturnsManagedEntity()
    {
        //Act
        $name = $this->furnitureController->getModelName();

        //Assert
        $this->assertTrue(class_exists($name));
        $this->assertIsArray(self::$em->getRepository($name)->findAll());
    }


    /**
     * Get constructor arguments from model test
     * @return string[][]|number[][]|number[][][]
     */
    public function furnitureValidArgsProvider()
    {
        return FurnitureTest::validConstructorArgumentProvider();
    }

    public function randomSkuProvider(): string
    {
        $furnPKs = $this->pks[Furniture::class];
        return $furnPKs[array_rand($furnPKs)]->getSku();
    }
}
