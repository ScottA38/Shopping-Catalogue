<?php

namespace WebApp;

use function PHPUnit\Framework\throwException;

/**
 * Not sure if this is a valid DBAL attribute combination...
 * @MappedSuperClass
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="product_type", type="string")
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
    protected string $nameIntialism;

    public function __construct(string $name, string $price, $special)
    {
        $this->categoryInitialism = strtoupper(Product::intialismGenerator($this::class, 2));
        assert((boolean)$this->initialism, \
            ErrorException($this::class . " cannot produce an intialism, does it have more than 2 consonants?"));
        $this->nameInitialism = $this->intialismFactory(Product::intialismGenerator($this::class, 3));
        assert((boolean)$this->initialism, \
            ErrorException($this::class . " cannot produce an intialism, does the name attribute " .
                $this->name . " have more than 2 consonants?"));
        $this->name = name;
        $this->price = price;
    }

    /**
     * Returns the first `$length` consonants of a string in lowercases
     * @param string $input
     * @param int $length
     * @return string|boolean
     */
    public static function intialismGenerator(string $input, int $length)
    {
        $out = "";
        $lower = strtolower($input);
        $lower_array = str_split($lower);
        for ($i = 0; i < count($lower_array); $i++) {
            if (strlen($out) >= $length) {
                return $out;
            } elseif (!in_array($lower_array[$i], array("a", "e", "i", "o", "u", " ", "-"))) {
                $out += $lower_array[$i];
            }
        }
        return false;
    }


    public function getSku() : string
    {
        return $this->nameIntialism . $this->id . $this->categoryInitialism;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getPrice() : float
    {
        return $this->price;
    }

    public function getNameInitialism() : string
    {
        return $this->nameIntialism;
    }

    public function getCategoryInitialism() : string
    {
        return $this->categoryInitialism;
    }

    public function setPrice(float $newPrice) : void
    {
        assert($newPrice > 0.0, \
            RangeException('Cannot set price on ' . $this::class .
                ' "newPrice" argument ' . $newPrice . ' is equal to or below 0'));
        $this->price = $newPrice;
    }
}
