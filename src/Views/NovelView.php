<?php

declare(strict_types=1);

namespace WebApp\Views;

use WebApp\Controllers\NovelController;
use Doctrine\ORM\EntityManager;

class NovelView extends ProductView
{
    public function __construct(EntityManager $em)
    {
        $this->controller = new NovelController($em);
    }
}
