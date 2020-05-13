<?php

declare(strict_types=1);

namespace WebApp\Models;

use WebApp\IComparable;

/**
 * Not sure if this is a valid DBAL attribute combination...
 * @MappedSuperClass
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="PRODUCT_TYPE", type="string")
 * @DiscriminatorMap({"furniture"= "Furniture", "book" = "Book", "dvd-disc" = "DVD"})
 *
 */
abstract class Product implements IComparable
{

    /**
     * Mapping an integer-only primary key for each Product implementer
     * @Id @Column(type="string", unique=TRUE)
     * @GeneratedValue(strategy="CUSTOM")
     * @CustomIdGenerator(class="WebApp\SkuGenerator")
     *
     * @var string
    */
    protected string $sku;

    /**
     * @Column(type="string", length=40)
     *
     * @var string
     */
    protected string $name;

    /**
     * @Column(type=decimal, precision=7, scale=2)
     *
     * @var float
     */
    protected float $price = 0.0;


    public function __construct(string $name, float $price)
    {
        $this->name = $name;
        $this->setPrice($price);
    }

    /**
     * Implement workaround custom-comparability between product classes
     * @param Product
     */
    public function compareTo(IComparable $other): bool
    {
        if (($other instanceof $this) === false) {
            $current = end(explode('/', __CLASS__));
            $arg = end(explode('/', get_class($other)));
            throw new \TypeError('Comparing instances of different types, should both be of type ' . $current .
                ' but got argument of type : ' . $arg);
        }
        return $this->getSku() === $other->getSku();
    }


    public function getSku(): string
    {
        return $this->sku;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $newPrice): void
    {
        if ($newPrice < 0.0) {
            throw new \RangeException('Cannot set price on ' . get_class($this) .
                ' "newPrice" argument ' . $newPrice . ' is equal to or below 0');
        } else {
            $this->price = $newPrice;
        }
    }
}
