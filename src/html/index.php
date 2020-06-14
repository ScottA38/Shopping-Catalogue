<?php

/**
 * A basic HTTP routing for each request of a user
 */

declare(strict_types=1);

require_once "/var/www/vendor/autoload.php";
require_once "/etc/db_secret.prod.php";

use WebApp\Bootstrap;
use WebApp\Util\ProductPopulator;
use WebApp\Models\Furniture;
use WebApp\Models\Novel;
use WebApp\Models\VideoDisc;

session_start();
//var_dump(session_id());

$entityNames = [Furniture::class, Novel::class, VideoDisc::class];

//get Doctrine entityManager
$bootstrap = new Bootstrap();
$em = $bootstrap->createEntityManager(DBPARAMS);

$request = parse_url($_SERVER['REQUEST_URI']);


if (session_status() == PHP_SESSION_NONE) {
    //echo "<h1>" . session_id() . "</h1>";

    //generate some Doctrine entity instances in the database
    $populator = new ProductPopulator($em);
    foreach ($entityNames as &$name) {
        $em->createQuery("DELETE FROM $name")->execute();
        $populator->populate($name, 5);
    }
}

switch ($request['path']) {
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
