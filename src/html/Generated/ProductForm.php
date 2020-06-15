<?php

declare(strict_types=1);

if (!isset($_GET['type'])) {
    die("No form type argument given to product form generation script!");
}

require_once "/var/www/vendor/autoload.php";
require_once "/etc/db_secret.prod.php";

use WebApp\Bootstrap;

$bootstrap = new Bootstrap();
$em = $bootstrap->createEntityManager(DBPARAMS);

$type = strtolower($_GET['type']);

$viewName = "WebApp\Views\\{$type}View";
$viewer = new $viewName($em);
echo $viewer->displayForm();
