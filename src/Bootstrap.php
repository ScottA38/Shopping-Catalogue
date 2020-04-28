<?php

declare(strict_types=1);

namespace WebApp;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

/* Singlton class to initialise Doctrine DBAL ORM library including operations:
 - Designate Metadata repository and metadata config (will be used to generate SQL db Schema later)
 - Generate an EntityManager class with database information which will manage mapping between written
 'model' classes and the database

 Code adopted from: https://www.doctrine-project.org/projects/doctrine-orm/en/current/reference/configuration.html#obtaining-an-entitymanager
 */
class Bootstrap
{

    //sinsgleton property
    private static ?Bootstrap $instance = null;

    private static ?EntityManager $em = null;

    private static $config = null;

    private array $setupParams = [
        'paths' => array(__DIR__ . "/models"),
        'isDevMode' => true,
        'proxyDir' => null,
        'cache' => null,
        'useSimpleAnnotoationReader' => false,
        'dbParams' => array(
            'driver' => 'pdo_mysql',
            'user' => 'admin',
            'password' => 'pa**w0rd',
            'dbname' => 'my_db'
        )

    ];

    private function __construct()
    {
        Bootstrap::$config =
        Setup::createAnnotationMetaDataConfiguration($this->setupParams['paths'], $this->setupParams['isDevMode']);
        Bootstrap::$em = EntityManager::create($this->setupParams['dbParams'], Bootstrap::$config);
    }

    public function getSetupParameter(string $key, ?string $secondaryKey)
    {
        if ($secondaryKey !== null) {
            if ($key !== 'dbParams') {
                throw new \InvalidArgumentException('A second parameter was given to ' . __METHOD__ .
                    ' for a non-nested key.');
            }
            return $this->setupParams[$key][$secondaryKey];
        } else {
            return $this->setupParams[$key];
        }
    }

    /**
     * Get singleton instance
     * @return Bootstrap
     */
    public static function getInstance(): Bootstrap
    {
        if (!Bootstrap::$instance) {
            Bootstrap::$instance = new Bootstrap();
        }
        return Bootstrap::$instance;
    }

    /**
     * Get singleton instances, return [{EntityManager}, {MetadataCache}]
     * @return array
     */
    public function getEntityManager(): EntityManager
    {
        //assertion that variables are instantiated
        assert(
            Bootstrap::$config !== null,
            'Bootstrap->__construct did not run correctly, no metadata cache configured'
        );
        assert(
            Bootstrap::$em !== null,
            'Bootstrap->__construct did not run correctly, no entity manager instantiated'
        );
        return Bootstrap::$em;
    }
}
