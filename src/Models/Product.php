<?php

declare(strict_types=1);

namespace WebApp\Models;

/**
 * Not sure if this is a valid DBAL attribute combination...
 * @MappedSuperClass
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="PRODUCT_TYPE", type="string")
 * @DiscriminatorMap({"furniture"= "Furniture", "book" = "Book", "dvd-disc" = "DVD"})
 *
 */
abstract class Product
{

    /**
     * Mapping an integer-only primary key for each Product implementer
     * @Id @Column(type="integer", unique=TRUE)
     * @GeneratedValue
     *
     * @var number
    */
    protected int $id;

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
    protected float $price;

    //a string concatentation of the product category
    protected string $categoryInitialism;

    //a string concatenation of the product name attribute
    protected string $nameInitialism;

    public function __construct(string $name, string $price)
    {
        $this->name = $name;
        $this->price = $price;
        $baseClassPath = explode("\\", get_class($this));
        $className = end($baseClassPath);
        $this->categoryInitialism = $this->initialismGenerator($className, 2);
        assert((bool)$this->categoryInitialism, "Intialism generator cannot produce an intialism, does " .
            $className . " have more than 2 consonants?");
        $this->nameInitialism = $this->initialismGenerator($name, 3);
        assert((bool)$this->nameInitialism, "Initialism generator cannot produce an intialism, does " .
            $name . " have more than 2 consonants?");
    }

    /**
     * Returns the first `$length` consonants of a string in lowercases
     * @param string $input
     * @param int $length
     * @return string|boolean
     */
    public static function initialismGenerator(string $input, int $length)
    {
        $out = "";
        $upper = strtoupper($input);
        $upper_array = str_split($upper);
        for ($i = 0; $i < count($upper_array); $i++) {
            if (!in_array($upper_array[$i], array("A", "E", "I", "O", "U", " ", "-"))) {
                $out .= $upper_array[$i];
            }
            if (strlen($out) >= $length) {
                return $out;
            }
        }
        return false;
    }


    public function getSku(): string
    {
        return $this->nameIntialism . $this->id . $this->categoryInitialism;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getNameInitialism(): string
    {
        return $this->nameIntialism;
    }

    public function getCategoryInitialism(): string
    {
        return $this->categoryInitialism;
    }

    public function setPrice(float $newPrice): void
    {
        assert($newPrice > 0.0, \
            RangeException('Cannot set price on ' . get_class($this) .
                ' "newPrice" argument ' . $newPrice . ' is equal to or below 0'));
        $this->price = $newPrice;
    }
}
