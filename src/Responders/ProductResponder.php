<?php

declare(strict_types=1);

namespace WebApp\Responders;

class ProductResponder
{
    protected static array $validationFilters = [
        'name' => [],
        'price' => [FILTER_VALIDATE_FLOAT, ["decimal" => 2, "min_range" => 0]],
        'dimensions' => [FILTER_VALIDATE_INT, ["min_range" => 0, "max_range" => 1000]],
        'size' => [FILTER_VALIDATE_INT, ["min_range" => 0]],
        'weight' => [FILTER_VALIDATE_FLOAT, ["decimal" => 2, "min_range" => 0, "max_range" => 1000]]
    ];

    protected static array $sanitisationFilters = [
        'name' => [FILTER_SANITIZE_STRING, ["flags" => [FILTER_FLAG_STRIP_HIGH, FILTER_FLAG_STRIP_HIGH]]],
        'price' => [FILTER_SANITIZE_NUMBER_FLOAT, ["flags" => [FILTER_FLAG_ALLOW_FRACTION]]],
        'dimensions' => [FILTER_SANITIZE_NUMBER_INT],
        'size' => [FILTER_SANITIZE_NUMBER_INT],
        'weight' => [FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION],
    ];

    /**
     * Function takes post array and
     */
    public static function filterArray(): ?array
    {
        $filtered = [];
        assert($_POST, "No post variables to process!");

        foreach (array_keys($_POST) as &$paramKey) {
            if (!array_key_exists($paramKey, self::$sanitisationFilters)) {
                throw new \Exception("parameter key '$paramKey' does not have a matching sanitisation filter");
            } elseif (array_key_exists($paramKey, self::$validationFilters)) {
                throw new \Exception("parameter key '$paramKey' does not have a matching validation filter");
            }
            $temp = filter_input(INPUT_POST, $paramKey, ...self::$sanitisationFilters[$paramKey]);
            $temp = filter_var($temp, ...self::$validationFilters[$paramKey]);
            assert($temp, "Variable processed unsuccessfully");
            $filtered[$paramKey] = $temp;
        }
        return $filtered;
    }
}
