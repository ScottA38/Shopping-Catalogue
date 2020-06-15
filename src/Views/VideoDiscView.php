<?php

declare(strict_types=1);

namespace WebApp\Views;

use WebApp\Controllers\VideoDiscController;
use Doctrine\ORM\EntityManager;

class VideoDiscView extends ProductView
{
    public function __construct(EntityManager $em)
    {
        $this->formHints = array_merge($this->formHints, [ 'size' => 'Enter the memory size of the DVD (MB)']);
        $this->controller = new VideoDiscController($em);
    }
}
