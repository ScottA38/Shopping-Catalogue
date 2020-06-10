<?php

declare(strict_types=1);

namespace WebApp\Tests\Controllers;

use WebApp\Controllers\NovelController;
use WebApp\Models\Novel;
use WebApp\Tests\Models\NovelTest;
use WebApp\Util\ProductPopulator;

class NovelControllerTest extends ProductControllerTest
{
    protected NovelController $novelController;

    protected function setUp(): void
    {
        parent::setUp();

        if (!isset($this->modelClass)) {
            $this->modelClass = Novel::class;
        }

        $this->novelController = new NovelController(self::$em);

        $populator = new ProductPopulator(self::$em);
        $this->pks = $populator->populate(Novel::class, 10);
    }

    /**
     * Empty table again
     * {@inheritDoc}
     * @see \PHPUnit\Framework\TestCase::tearDown()
     */
    protected function tearDown(): void
    {
        self::$em->createQuery("DELETE FROM $this->modelClass")->execute();
        assert(count(self::$em->getRepository(Novel::class)->findAll()) === 0);
    }

    /**
     * @dataProvider validArgsProvider
     * @param string $name
     * @param float $price
     * @param int $weight
     */
    public function testAddProduct(string $name, float $price, float $weight)
    {
        $id = $this->novelController->add($name, $price, $weight);

        $this->assertIsObject(self::$em->find(Novel::class, $id));
    }

    public function testRemoveProduct()
    {
        $sku = $this->randomSkuProvider();

        $this->novelController->remove($sku);

        $this->assertTrue(self::$em->find(Novel::class, $sku) === null);
    }

    public function validArgsProvider()
    {
        $novelTest = new Noveltest();
        return $novelTest->validConstructorArgumentProvider();
    }
}
