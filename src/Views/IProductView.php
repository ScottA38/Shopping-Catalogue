<?php

declare(strict_types=1);

namespace WebApp\Views;

/**
 * Basic functionality contract for a domain model view
 * @author ScottAnderson
 *
 */
interface IProductView
{
    /**
     * Generates html 'cards' based upon data in ORM for a specific controlled type
     * @return string
     */
    public function displayAll(): array;

    /**
     * Method which generates a form for given ORM model data blueprint
     * @return string
     */
    public function displayForm(): string;
}
