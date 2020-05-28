<?php

declare(strict_types=1);

namespace WebApp\Views;

use Doctrine\ORM\EntityManager;
use WebApp\Bootstrap;
use WebApp\Models\Product;

class ProductView
{
    protected array $controllers = [];

    /**
     * Generic product viewing class asks for fully qualified class names of defined controllers
     * @param array $controllerNames
     */
    public function __construct(array $dbParams, string $classPath = "\\WebApp\Controllers\\")
    {
        $bootstrap = new Bootstrap();
        $em = $bootstrap->createEntityManager($dbParams);

        $classNames = array_map(function ($meta) {
            return $meta->getName();
        }, $em->getMetadataFactory()->getAllMetadata());

        foreach ($classNames as &$className) {
            $nss = str_split($className);
            $controllerPath = $classPath . end($nss);
            //assured that all controller only take entityManager as single argument
            array_push($this->controllers, new $controllerPath($em));
        }
    }

    public function displayAll()
    {
        $output = [];
        foreach ($this->controllers as &$controller) {
            $insts = $controller->getAll();
            foreach ($insts as &$inst) {
                array_push($output, self::buildCard($inst));
            }
        }
        return $output;
    }

    protected static function buildCard(Product $entity, array $fieldMap)
    {
        $nSs = str_split(get_class($entity));
        $className = end($nSs);
        $cardHeader = "<div id='{$entity->getSku()}'class='card'>
                    <img src='...' class='card-img-top'>
                    <div class='card-body'>
                        <h5 class='card-title'>$className</h5>";
        $cardFooter = "<a href='TODO' class='btn btn-primary>Delete Item</a></div?</div>";
        $content = "";
        foreach ($fieldMap as &$field) {
            $content .= "<p class='card-text'>{$entity->get{$field}()}</p>";
        }
        return $cardHeader . $content . $cardFooter;
    }
}
