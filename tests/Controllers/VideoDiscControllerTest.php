<?php

declare(strict_types=1);

namespace WebApp\Tests\Controllers;

use WebApp\Controllers\VideoDiscController;
use WebApp\Models\VideoDisc;
use WebApp\Tests\Models\VideoDiscTest;
use WebApp\Util\ProductPopulator;

class VideoDiscControllerTest extends ProductControllerTest
{
    protected VideoDiscController $discController;

    protected function setUp(): void
    {
        parent::setUp();

        if (!isset($this->modelClass)) {
            $this->modelClass = VideoDisc::class;
        }

        $this->discController = new VideoDiscController(self::$em);

        $populator = new ProductPopulator(self::$em);
        $this->pks = $populator->populate(VideoDisc::class, 10);
    }

    protected function tearDown(): void
    {
        self::$em->createQuery("DELETE FROM $this->modelClass")->execute();
        assert(count(self::$em->getRepository(VideoDisc::class)->findAll()) === 0);
    }

    /**
     * @dataProvider validArgsProvider
     * @param string $name
     * @param float $price
     * @param int $size
     */
    public function testAddProduct(string $name, float $price, int $size)
    {
        $id = $this->discController->add($name, $price, $size);

        $this->assertIsObject(self::$em->find(VideoDisc::class, $id));
    }

    public function testRemoveProduct()
    {
        $sku = $this->randomSkuProvider();

        $this->discController->remove($sku);

        $this->assertTrue(self::$em->find(VideoDisc::class, $sku) === null);
    }

    public function validArgsProvider()
    {
        $discTest = new VideoDiscTest();
        return $discTest->validConstructorArgumentProvider();
    }
}
