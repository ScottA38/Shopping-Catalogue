<?php

declare(strict_types=1);

namespace WebApp\Views;

use WebApp\Controllers\VideoDiscController;
use Doctrine\ORM\EntityManager;

class VideoDiscView extends ProductView
{
    public function __construct(EntityManager $em)
    {
        parent::__construct();
        $this->controller = new VideoDiscController($em);
    }
}
