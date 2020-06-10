<?php

declare(strict_types=1);

namespace WebApp\Tests\Controllers;

use PHPUnit\Framework\TestCase;
use WebApp\Bootstrap;
use Doctrine\ORM\EntityManager;

abstract class ProductControllerTest extends TestCase
{
    protected string $modelClass;

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

    public function randomSkuProvider(): string
    {
        $furnPKs = $this->pks[$this->modelClass];
        return $furnPKs[array_rand($furnPKs)]->getSku();
    }

    abstract public function validArgsProvider();
}
