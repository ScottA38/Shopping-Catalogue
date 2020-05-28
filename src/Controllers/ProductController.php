<?php

declare(strict_types=1);

namespace WebApp\Controllers;

use Doctrine\ORM\EntityManager;
use WebApp\Models\Product;

/**
 * Base class to cover the core functionality a product Controller should implement
 */
abstract class ProductController implements IProductController
{
    protected EntityManager $em;

    protected string $model;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function add($name, $price, $dimensions): string
    {
        $product = new $this->model($name, $price, $dimensions);
        $this->em->persist($product);
        $this->em->flush();
        return $product->getSku();
    }

    public function remove(string $sku): Product
    {
        $target = $this->em->find($this->model, $sku);
        $this->em->remove($target);
        $this->em->flush();
        return $target;
    }

    public function removeAll(): array
    {
        $ents = $this->em->getRepository($this->model)->findAll();
        foreach ($ents as &$record) {
            $this->em->remove($record);
        }
        $this->em->flush();
        return $ents;
    }

    public function updatePrice($sku, $price): void
    {
        $target = $this->em->find($this->model, $sku);
        $target->setPrice($price);
    }

    public function get(string $sku): Product
    {
        return $this->em->find($this->model, $sku);
    }

    public function getAll(): array
    {
        return $this->em->getRepository($this->model)->findAll();
    }

    public function getFieldMap(): array
    {
        return $this->em->getClassMetadata($this->model)->fieldMappings;
    }

    public function getModelName(): string
    {
        return $this->model;
    }
}
