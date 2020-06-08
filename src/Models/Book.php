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

    public function __construct(string $name, float $price, float $weight)
    {
        parent::__construct($name, $price);
        if ($weight < 0) {
            throw new \Exception("Weight argument to " . __METHOD__ . " cannot be a negative number.");
        }
        $this->weight = $weight;
    }

    public function getWeight()
    {
        return $this->weight;
    }
}
