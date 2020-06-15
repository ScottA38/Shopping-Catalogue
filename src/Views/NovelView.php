<?php

declare(strict_types=1);

namespace WebApp\Views;

use WebApp\Controllers\NovelController;
use Doctrine\ORM\EntityManager;

class NovelView extends ProductView
{
    public function __construct(EntityManager $em)
    {
        $this->formHints = array_merge($this->formHints, [ 'weight' => 'Enter the weight of the Book (kg)']);
        $this->controller = new NovelController($em);
    }
}
