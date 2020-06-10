<?php

declare(strict_types=1);

namespace WebApp\Tests\Models;

use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManager;
use WebApp\Bootstrap;

abstract class ProductTest extends TestCase
{
    protected static EntityManager $em;

    private static array $dbParams = array('url' => "mysql://dev_admin:p455w0rd@127.0.0.1:3306/my_db");


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

    abstract public function testCanBeInstantiatedWithValidConstructorArgs($name, $price, $special);

    abstract public function testCannotBeInstantiatedWithInvalidArgs($name, $price, $special, $exception);

    abstract public function validConstructorArgumentProvider();

    abstract public function invalidConstructorArgumentProvider();
}
