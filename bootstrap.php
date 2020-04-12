<?php
/* File to initialise Doctrine DBAL ORM library including operations:
- Designate Metadata repository and metadata config (will be used to generate SQL db Schema later)
- Generate an EntityManager class with database information which will manage mapping between written
'model' classes and the database

Code adopted from: https://www.doctrine-project.org/projects/doctrine-orm/en/current/reference/configuration.html#obtaining-an-entitymanager
*/

require_once "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

//placeholder for later paths to ORM entity models
$paths = array(__DIR__."/src/models");
$isDevMode = true;

$dbParams = array(
    'driver' => 'pdo_mysql',
    'user' => 'admin',
    'password' => 'pa**w0rd',
    'dbname' => 'my_db'
);

$config = Setup::createAnnotationMetaDataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);
