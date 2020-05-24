<?php

declare(strict_types=1);

namespace WebApp;

use Doctrine\ORM\Id\AbstractIdGenerator;
use Doctrine\ORM\EntityManager;

class SkuGenerator extends AbstractIdGenerator
{
    /**
     * Generate an SKU property
     * {@inheritDoc}
     * @see \Doctrine\ORM\Id\AbstractIdGenerator::generate()
     * @param mixed (has to be mixed because mock entity manager might be used)
     * @param
     */
    public function generate(EntityManager $em, $entity): string
    {
        //sanity-checking the parameter
        assert(is_subclass_of($entity, 'WebApp\Models\Product'));

        $baseClassPath = explode("\\", get_class($entity));
        $className = end($baseClassPath);

        $categoryInitialism = SkuGenerator::initialismGenerator($className, 2);
        $nameInitialism = SkuGenerator::initialismGenerator($entity->getName(), 3);

        //working sku until no collisions
        $sku = "";
        $num = 1;
        $count = count($em->getRepository(get_class($entity))->findAll());
        while ($num <= ($count + 1)) {
            $sku = $nameInitialism . $num . $categoryInitialism;
            if (count($em->getRepository(get_class($entity))->findBy(['sku' => $sku])) === 0) {
                break;
            }
            $num++;
        }
        return $sku;
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
        throw new \LengthException('An initialism cannot be created from ' . $input . ', too few consonants');
    }
}
