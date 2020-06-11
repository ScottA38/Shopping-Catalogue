<?php

/**
 * A basic HTTP routing for each request of a user
 */

declare(strict_types=1);

ini_set('error_log', '/var/log/php-error.log');

require_once "/var/www/vendor/autoload.php";
require_once "/etc/db_secret.prod.php";

use WebApp\Bootstrap;
use WebApp\Util\ProductPopulator;
use WebApp\Models\Furniture;
use WebApp\Models\Novel;
use WebApp\Models\VideoDisc;

//get Doctrine entityManager
$bootstrap = new Bootstrap();
$em = $bootstrap->createEntityManager(DBPARAMS);

$entityNames = [Furniture::class, Novel::class, VideoDisc::class];

//generate some Doctrine entity instances in the database
$populator = new ProductPopulator($em);
foreach ($entityNames as &$name) {
    $populator->populate($name, 20);
}

//echo "This is after bootstrapping";

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/':
        require __DIR__ . '/views/index.php';
        break;
    case ' ':
        require __DIR__ . '/views/index.php';
        break;
    case '/phpinfo':
        phpinfo();
        break;
    case '/add_product':
        require __DIR__ . '/views/add_product.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
}

//clear all tables again
foreach ($entityNames as &$name) {
    $query = $em->createQuery("DELETE FROM $name");
    $query->execute();
}
