<?php

declare(strict_types=1);

namespace WebApp;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

/* Class to initialise Doctrine DBAL ORM EntityManager:
 - Designate Metadata repository and metadata config (will be used to generate SQL db Schema later)
 - Generate an EntityManager class with database information which will manage mapping between written
 'model' classes and the database
 */
class Bootstrap
{

    private array $setupParams = [
        'paths' => array(__DIR__ . "/models"),
        'isDevMode' => true,
        'proxyDir' => null,
        'cache' => null,
        'useSimpleAnnotoationReader' => false
    ];

    /**
     * Create an EntityManager instance
     * @return array
     */
    public function createEntityManager(array $dbParams): EntityManager
    {
        $config =
        Setup::createAnnotationMetaDataConfiguration($this->setupParams['paths'], $this->setupParams['isDevMode']);
        return EntityManager::create($dbParams, $config);
    }
}
