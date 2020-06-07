<?php

declare(strict_types=1);

namespace WebApp\Tests\Views;

interface IProductViewTest
{
    /**
     * Will parse return to ensure valid HTML output from described function
     */
    public function testDisplayAllOutputsValidHTML();

    /**
     * Will parse output of described method to ensure valid HTML string is returned
     */
    public function testDisplayFormOutputsValidHTML();
}
