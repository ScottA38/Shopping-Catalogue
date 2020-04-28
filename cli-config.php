<?php

/* Config file to connect DBAL EntityManager instance ( from ./bootstrap.php ) to ./vendor/bin/doctrine
such that CLI commands can be used

adopted from https://www.doctrine-project.org/projects/doctrine-orm/en/current/reference/configuration.html
*/

use Doctrine\ORM\Tools\Console\ConsoleRunner;

$bootstrap = 'src/bootstrap.php';

require_once $bootstrap;

//checking for existence of $entityManager variable from $bootstrap's php file execution
if (isset($entityManager)) {
    return ConsoleRunner::createHelperSet($entityManager);
} else {
    die("DBAL 'EntityManager' instance not found within $bootstrap, cannot instantiate CLI");
}
