<?php

declare(strict_types=1);

namespace WebApp\Controllers;

use Doctrine\ORM\EntityManager;
use WebApp\Models\Furniture;

class FurnitureController extends ProductController
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
        $this->model = Furniture::class;
    }
}
