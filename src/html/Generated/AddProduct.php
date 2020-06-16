<?php

declare(strict_types=1);

if (!isset($_POST['type']) || !isset($_POST['name']) || !isset($_POST['price']) || !isset($_POST['special'])) {
    echo "<h1>No form type argument given to product form generation script!</h1>";
}
#debug
var_dump($_POST);

assert(isset($em), "No Doctrine entityManager initialised for the view file");

$controllerType = strtolower($_POST['type']);
$controllerName = "WebApp\Controllers\\{$controllerType}Controller";
$controller = new $controllerName($em);

$postParams = $_POST;
unset($postParams['submit']);

$sku = $controller->add($_POST['name'], (float)$_POST['price'], $_POST['special']);

echo "<h2>Successfully made a new product with sku: $sku</h2>";
