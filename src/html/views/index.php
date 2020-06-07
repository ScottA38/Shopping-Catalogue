<?php

declare(strict_types=1);

use WebApp\Views\FurnitureView;

assert(isset($em), "No Doctrine entityManager initialised for the view file");

include "templates/header.html";

$furnView = new FurnitureView($em);
$cards = $furnView->displayAll();

foreach ($cards as &$card) {
    echo $card;
}

include "templates/footer.html";
