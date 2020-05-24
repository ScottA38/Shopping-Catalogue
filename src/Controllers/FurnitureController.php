<?php

declare(strict_types=1);

namespace WebApp\Controllers;

use Doctrine\ORM\EntityManager;
use WebApp\Models\Furniture;

class FurnitureController implements IProductController
{

    protected EntityManager $em;


    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function add($name, $price, $dimensions): string
    {
        $furn = new Furniture($name, $price, $dimensions);
        $this->em->persist($furn);
        $this->em->flush();
        return $furn->getSku();
    }

    public function remove($sku): void
    {
        $target = $this->em->find(Furniture::class, $sku);
        $this->em->remove($target);
        $this->em->flush();
    }

    public function removeAll(): array
    {
        $ents = $this->em->getRepository(Furniture::class)->findAll();
        foreach ($ents as &$record) {
            $this->em->remove($record);
        }
        $this->em->flush();
        return $ents;
    }

    public function updatePrice($sku, $price): void
    {
        $target = $this->em->find(Furniture::class, $sku);
        $target->setPrice($price);
    }
}
