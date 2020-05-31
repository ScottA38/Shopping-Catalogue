<?php

declare(strict_types=1);

namespace WebApp\Views;

use WebApp\Controllers\FurnitureController;
use Doctrine\ORM\EntityManager;

class FurnitureView extends ProductView
{
    /**
     * Instantiate viewer of Product type. EntityManager should be passed in pre-instantiated
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->controller = new FurnitureController($em);
    }
}
