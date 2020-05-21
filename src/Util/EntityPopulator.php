<?php

declare(strict_types=1);

namespace WebApp\Util;

use Doctrine\ORM\EntityManager;
use Faker\ORM\Doctrine\Populator;
use Faker\Factory;
use WebApp\Models\Product;
use Faker\Generator;

class EntityPopulator
{
    private EntityManager $em;
    private Generator $generator;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->generator = Factory::create();
    }

    private function getspecialInstructions()
    {
        $nameReducer = function ($carry, $lChar) {
            if (!in_array($lChar, ["a", "e", "i", "o", "u"])) {
                $carry++;
            }
            return $carry;
        };
        return [
            'price' => function () {
                return $this->generator->randomFloat(2, 0, 10000);
            },
            'name' => function () use ($nameReducer) {
                $name = $this->generator->unique()->company;
                while (array_reduce(str_split(strtolower($name)), $nameReducer) < 3) {
                    $name = $this->generator->unique()->company;
                }
                return $name;
            },
            'dimensions' => function () {
                return [
                    $this->generator->randomNumber(3),
                    $this->generator->randomNumber(3),
                    $this->generator->randomNumber(3)
                ];
            },
            'release' => function () {
            }
            ];
    }

    public function getEntityManager(): EntityManager
    {
        return $this->em;
    }


    /**
     * Populate the database with a given amount of DBAL entity. Returns PK of each popluated element
     * @param Product $entity
     * @param int $amount
     * @return array
     */
    public function populate(string $className, int $amount)
    {
        $metadata = $this->em->getClassMetadata($className);
        $fieldNames = array_keys($metadata->fieldMappings);
        $specialInstructions = $this->getspecialInstructions();
        $instructionKeys = array_keys($specialInstructions);
        foreach ($instructionKeys as &$instructionKey) {
            if (!in_array($instructionKey, $fieldNames)) {
                unset($specialInstructions[$instructionKey]);
            }
        }
        $populator = new Populator($this->generator, $this->em, 5);
        $populator->addEntity($className, $amount, $specialInstructions);
        return $populator->execute();
    }

    /**
     * Cheeky helper function that should be implemented in a concrete class controller
     * @param array $entities
     */
    public function removeAllEntities(array $entities)
    {
        foreach ($entities as &$ent) {
            $this->em->remove($ent);
        }
        $this->em->flush();
    }
}
