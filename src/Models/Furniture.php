<?php

declare(strict_types=1);

namespace WebApp\Models;

/**
 * @Entity
 * @author ScottAnderson
 *
 */
class Furniture extends Product
{

    /**
     * @column(type="array")
     *
     * @var array
     */
    protected $dimensions;


    /**
     * Hard-coded product type declaration to ensure correct mapping for single-table inheritance
     * @column(type='string')
     *
     * @var string
     */
    public const PRODUCT_TYPE = 'furniture';

    public function __construct(string $name, float $price, array $dimensions)
    {
        parent::__construct($name, $price);

        //sanity check on dimensions argument
        if (count($dimensions) !== 3) {
            throw new \LengthException('\'$dimensions\' array passed to ' . __CLASS__
                . '\'s constructor is ' . count($dimensions) . ' items not 3.');
        }
        $this->dimensions = $dimensions;
    }

    public function getDimensions(): array
    {
        return $this->dimensions;
    }
}
