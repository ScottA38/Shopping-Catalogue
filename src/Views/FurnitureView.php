<?php

declare(strict_types=1);

namespace WebApp\Views;

use WebApp\Controllers\FurnitureController;
use Doctrine\ORM\EntityManager;

class FurnitureView extends ProductView
{
    protected array $arrayFormDefinitions = array(
        "dimensions" => array(
            "length" => 3,
            "membersType" => "integer"
        )
    );

    /**
     * Instantiate viewer of Product type. EntityManager should be passed in pre-instantiated
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->formHints = array_merge($this->formHints, [ 'dimensions' =>
            ['Please enter the height (cm)', 'Please enter the width (cm)', 'Please enter the height (cm)']]);
        $this->controller = new FurnitureController($em);
    }
}
