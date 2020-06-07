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
    protected array $arrayFormDefinitions;

    /**
     * This property must be initialised for each concrete instance of this base class
     * @var ProductController
     */
    protected ProductController $controller;

    protected array $formTypeMappings = [
        "string" => "type='text'",
        "integer" => "type='number' step='1'",
        "decimal" => "type='number' step='0.01'"
    ];

    /**
     * Abstract constructor to ensure specific properties are initialised
     */
    public function __construct()
    {
        assert(isset($this->arrayFormDefinitions));
    }

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
        $cardHeader = "<div id='{$entity->getSku()}' class='card'>
                    <img src='...' class='card-img-top'>
                    <div class='card-body'>
                        ";
        $cardFooter = "<h3 class='card-title'>$className</h3>
                <a href='#' class='btn btn-primary'>Delete Item</a>
            </div>
        </div>";
        $content = "";
        foreach ($this->controller->getFieldMap() as &$field) {
            $methodName = "get" . $field['fieldName'];
            $value = $entity->$methodName();
            if (gettype($value) === 'array') {
                $value = implode(", ", $value);
            }
            $content .= "\n<h5>{$field['fieldName']}</h5>";
            $content .= "\n<p class='card-text'>$value</p>";
        }
        return $cardHeader . $content . $cardFooter;
    }

    public function displayForm(): string
    {
        $formHeader = "<form action='TODO' method='#'>";
        $formFields = "";
        $formFooter = "</form>";
        foreach (array_values($this->controller->getFieldMap()) as $fieldConfig) {
            //var_dump($fieldConfig);
            $formFields .= $this->makeFormField($fieldConfig);
        }
        return $formHeader . $formFields . $formFooter;
    }

    protected function makeFormField(array $fieldConfig)
    {
        $formHeader = "<div class='form-group'>";
        $inputs = "";
        $formFooter = "</div>";
        //identifier name in form inputs
        $inputName = $fieldConfig['fieldName'] . "Input";
        if ($fieldConfig['type'] === "array") {
            //sanity check that this array type is defined for the [entityType]View class
            assert(isset($this->arrayFormDefinitions[$fieldConfig['fieldName']]));
            //get member information for specific array type field
            $arrayFieldDefinition = $this->arrayFormDefinitions[$fieldConfig['fieldName']];
            $membersTypeMapping = $this->formTypeMappings[$arrayFieldDefinition['membersType']];
            for ($i = 0; $i < $arrayFieldDefinition['length']; $i++) {
                $arrayInputName = $inputName . "[" . $i . "]";
                $inputs .= "<label for='$arrayInputName'>{$fieldConfig['fieldName']}</label>
            <input $membersTypeMapping class='form-control' id='$arrayInputName'>";
            }
        } else {
            $inputs = "<label for='$inputName'>{$fieldConfig['fieldName']}</label>
            <input {$this->formTypeMappings[$fieldConfig['type']]} class='form-control' id=$inputName>";
        }

        return $formHeader . $inputs . $formFooter;
    }
}
