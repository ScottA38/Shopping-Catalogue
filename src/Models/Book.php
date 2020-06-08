<?php

declare(strict_types=1);

namespace WebApp\Models;

/**
 * @Entity
 * @author ScottAnderson
 *
 */
class Book extends Product
{
    /**
     * @column(type='decimal', precision=5, scale=2)
     * @var float
     */
    protected float $weight;

    public const PRODUCT_TYPE = 'Book';

    public function __construct(string $name, float $price, int $weight)
    {
        parent::construct($name, $price);

        $this->weight = $weight;
    }

    public function getWeight()
    {
        return $this->weight;
    }
}
