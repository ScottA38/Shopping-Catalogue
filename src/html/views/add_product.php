<?php

declare(strict_types=1);

use HaydenPierce\ClassFinder\ClassFinder;

assert(isset($em), "No Doctrine entityManager initialised for the view file");

include "templates/header.html";

$classNames = ClassFinder::getClassesInNamespace('WebApp\Models');
$classNames = array_map(function ($value) {
    return end(explode('\\', $value));
}, $classNames);
$classNames = array_filter($classNames, function ($value) {
    return !($value === "Product");
});


echo "  <label class='mt-3 label label-info' for='typeSelector'>Choose a product type:</label>
        <select class='mb-3 form-control' id='typeSelector' name='typeSelector' onchange='asyncDisplayForm(event)'>";

foreach ($classNames as &$name) {
    echo "          <option value='$name'>$name</option>";
}

echo "      </select>\n<h2 class='my-3 text-muted'>Enter product details here...</h2>
    <script type='text/javascript'>asyncDisplayForm()</script>";

include "templates/footer.html";
