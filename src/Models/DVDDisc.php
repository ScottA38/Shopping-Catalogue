<?php

declare(strict_types=1);

namespace WebApp\Models;

/**
 * @entity
 * @author ScottAnderson
 */
class DVDDisc extends Product
{
    /**
     * @column(type="int")
     * @var int
     */
    protected int $size;

    public const PRODUCT_TYPE = 'dvd-disc';

    public function __construct(string $name, float $price, int $size)
    {
        parent::__construct($name, $price);

        //sanity check for size argument
        if ($size < 0) {
            throw new \RangeException('size argument to ' . __METHOD__ . " is a negative number");
        }
        $this->size = $size;
    }

    public function getSize()
    {
        return $this->size;
    }
}
