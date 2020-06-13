<?php

declare(strict_types=1);

use WebApp\Views\FurnitureView;
use WebApp\Views\NovelView;
use WebApp\Views\VideoDiscView;

assert(isset($em), "No Doctrine entityManager initialised for the view file");

include "templates/header.html";

$viewers = [new FurnitureView($em), new NovelView($em), new VideoDiscView($em)];
$cards = [];

foreach ($viewers as &$view) {
    $cards = array_merge($cards, $view->displayAll());
}
foreach ($cards as &$card) {
    echo $card;
}

include "templates/footer.html";
