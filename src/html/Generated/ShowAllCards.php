<?php

declare(strict_types=1);

require_once "/var/www/vendor/autoload.php";
require_once "/etc/db_secret.prod.php";

use WebApp\Bootstrap;
use WebApp\Views\FurnitureView;
use WebApp\Views\NovelView;
use WebApp\Views\VideoDiscView;

//get Doctrine entityManager
$bootstrap = new Bootstrap();
$em = $bootstrap->createEntityManager(DBPARAMS);

if (isset($_GET['action'])) {
    assert(isset($_GET['sku']));
    assert(isset($_GET['type']));
    $controllerName = "WebApp\Controllers\\{$_GET['type']}Controller";
    switch ($_GET['action']) {
        case 'delete':
            $controller = new $controllerName($em);
            $controller->remove($_GET['sku']);
            break;
    }
}

$viewers = [new FurnitureView($em), new NovelView($em), new VideoDiscView($em)];
$cards = [];
foreach ($viewers as &$view) {
    $cards = array_merge($cards, $view->displayAll());
}
foreach ($cards as &$card) {
    echo $card;
}
