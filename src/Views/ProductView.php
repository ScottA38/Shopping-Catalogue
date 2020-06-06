<?php

declare(strict_types=1);

namespace WebApp\Views;

use WebApp\Bootstrap;
use WebApp\Models\Product;
use WebApp\Controllers\ProductController;
use Doctrine\ORM\EntityManager;
use WebApp\Controllers\IProductController;

abstract class ProductView implements IProductView
{
    /**
     * This property must be initialised for each concrete instance of this base class
     * @var ProductController
     */
    protected ProductController $controller;

    protected array $formTypeMappings = [
        "string" => "type='text'",
        "integer" => "type='number' step='1'",
        "float" => "type=number step='0.01'"
    ];

    /**
     * Function to build all cards which display products for a specific type
     * @return array
     */
    public function displayAll(): array
    {
        $output = [];
        $insts = $this->controller->getAll();
        foreach ($insts as &$inst) {
            array_push($output, self::buildCard($inst));
        }
        return $output;
    }

    protected function buildCard(Product $entity)
    {
        $nSs = explode("\\", get_class($entity));
        $className = end($nSs);
        $cardHeader = "<div id='{$entity->getSku()}'class='card'>
                    <img src='...' class='card-img-top'>
                    <div class='card-body'>
                        <h5 class='card-title'>$className</h5>";
        $cardFooter = "<a href='#' class='btn btn-primary>Delete Item</a></div?</div>";
        $content = "";
        foreach ($this->controller->getFieldMap() as &$field) {
            $methodName = "get" . $field['fieldName'];
            $value = $entity->$methodName();
            if (gettype($value) === 'array') {
                $value = implode(", ", $value);
            }
            $content .= "<p class='card-text'>$value</p>";
        }
        return $cardHeader . $content . $cardFooter;
    }

    public function displayForm(): string
    {
        $formHeader = "<form action='TODO' method='#'>";
        $formFields = "";
        $formFooter = "</form>";
        foreach (array_values($this->controller->getFieldMap()) as $fieldConfig) {
            $formFields .= $this->makeFormField($fieldConfig);
        }
        return $formHeader . $formFields . $formFooter;
    }

    protected function makeFormField(array $fieldConfig)
    {
        if ($fieldConfig['type'] === "array") {
            throw new \Exception('array form field generator not yet implemented');
        }
        $inputName = $fieldConfig['fieldName'] . "Input";
        return "<div class='form-group'>
                    <label for='$inputName'>{$fieldConfig['fieldName']}</label>
                    <input {$this->formTypeMappings[$fieldConfig]} class='form-control id=$inputName>
                </div>";
    }
}
