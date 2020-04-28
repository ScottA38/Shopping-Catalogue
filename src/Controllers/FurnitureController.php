<?php

declare(strict_types=1);

namespace WebApp\Controllers;

use WebApp\Bootstrap;

class FurnitureController
{

    public function __construct()
    {
        Bootstrap::getEntityManager();
    }
}
