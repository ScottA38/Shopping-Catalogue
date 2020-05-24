<?php

/* Config file to connect DBAL EntityManager instance ( from ./bootstrap.php ) to ./vendor/bin/doctrine
such that CLI commands can be used
*/

require_once __DIR__ . '/vendor/autoload.php';

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use WebApp\Bootstrap;

$dbParams = array('url' => "mysql://dev_admin:p455w0rd@127.0.0.1:3306/my_db");
$bootstrap = new Bootstrap();
$entityManager = $bootstrap->createEntityManager($dbParams);

//checking for existence of $entityManager variable from $bootstrap's php file execution
if (isset($entityManager)) {
    return ConsoleRunner::createHelperSet($entityManager);
} else {
    die("DBAL 'EntityManager' instance not found within $bootstrap, cannot instantiate CLI");
}
