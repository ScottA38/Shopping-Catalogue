<?php

declare(strict_types=1);

use WebApp\Responders\ProductResponder;

#debug
//var_dump($_POST);

assert(isset($em), "No Doctrine entityManager initialised for the view file");

//set up appropriate product controller type to add product
$controllerType = strtolower($_POST['type']);
$controllerName = "WebApp\Controllers\\{$controllerType}Controller";
$controller = new $controllerName($em);
unset($_POST['type']);

$filtered = ProductResponder::processPost();
unset($_POST['name'], $_POST['price']);

if (count($_POST) !== 1) {
    throw new \Exception(
        "Unexpected length of \$filtered variable array: " . count($filtered) .
        ", are you passing extra parameters to \$_POST?"
    );
}

$sku = $controller->add($filtered['name'], $filtered['price'], $filtered[array_keys($_POST)[0]]);

echo "<h2>Successfully made a new product with sku: $sku</h2>";

unset($_POST);
