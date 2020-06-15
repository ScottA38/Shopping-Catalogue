<?php

declare(strict_types=1);

namespace WebApp\Views;

use WebApp\Models\Product;
use WebApp\Controllers\ProductController;

abstract class ProductView implements IProductView
{
    protected array $arrayFormDefinitions;

    /**
     * This property must be initialised for each concrete instance of this base class
     * @var ProductController
     */
    protected ProductController $controller;

    protected array $formHints = [
        'name' => 'Specify the name of the new Product (text)',
        'price' => 'Please specify the price of the Product (€NN.NN)'
    ];

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
        //assert(isset($this->arrayFormDefinitions));
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
        $cardHeader = "\n<div id='{$entity->getSku()}' class='card'>
    <img src='...' class='rounded img-thumbnail'>
    <div class='card-body'>";
        $cardFooter = "\n<h3 class='card-title'>$className</h3>
        <a class='btn btn-primary' onclick='asyncDisplayCards(event)'>Delete Item</a>
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
        $formHeader = "<form action='responder' method='POST'>";
        $formFields = "";
        $formFooter = "<input type='submit' name='submit' value='submit'>\n</form>";
        foreach (array_values($this->controller->getFieldMap()) as $fieldConfig) {
            if ($fieldConfig['fieldName'] === 'sku') {
                continue;
            }
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

        //data helpers
        $inputName = $fieldConfig['fieldName'];

        if ($fieldConfig['type'] === "array") {
            $inputs = $this->makeArrayFormField($fieldConfig, $inputName);
        } else {
            $inputs = "<label class='lead font-weight-bold' for='$inputName'>{$fieldConfig['fieldName']}:
<span class='text-muted'>{$this->formHints[$fieldConfig['fieldName']]}</span></label>
            <input {$this->formTypeMappings[$fieldConfig['type']]} class='form-control'
id=$inputName name='$inputName'>";
        }

        return $formHeader . $inputs . $formFooter;
    }

    private function makeArrayFormField(array $fieldConfig, string $inputName)
    {
        $fields = "";
        $formHints = $this->formHints[$fieldConfig['fieldName']];

        //get member information for specific array type field
        $arrayFieldDefinition = $this->arrayFormDefinitions[$fieldConfig['fieldName']];
        assert(is_array($formHints) && count($formHints) === $arrayFieldDefinition['length']);

        for ($i = 0; $i < $arrayFieldDefinition['length']; $i++) {
            $arrayInputName = $inputName . "[" . $i . "]";

            $fields .= "\n<label class='lead font-weight-bold' for='$arrayInputName'>$inputName:
<span class='text-muted'>{$formHints[$i]}</span></label>
            <input {$this->formTypeMappings[$arrayFieldDefinition['membersType']]} class='form-control'
id='$arrayInputName' name='$arrayInputName'>";
        }
        return $fields;
    }
}
