<?php

declare(strict_types=1);

use WebApp\Views\FurnitureView;

assert(isset($em), "No Doctrine entityManager initialised for the view file");

include "templates/header.html";

echo "<h2 class='my-3 text-muted'>Enter product details here...</h2>";

$furnView = new FurnitureView($em);
echo $furnView->displayForm();

include "templates/footer.html";
