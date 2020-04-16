<?php

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
    const PRODUCT_TYPE = 'furniture';

    public function __construct(string $name, float $price, array $dimensions)
    {
        parent::__construct($name, $price);

        //sanity check on dimensions argument
        assert(is_array($dimensions), 'The argument to the ' .
            get_class($this) . ' constructor is not of type "array"');
        $this->dimensions = $dimensions;
    }

    public function getDimensions() : array
    {
        return $this->dimensions;
    }
}
