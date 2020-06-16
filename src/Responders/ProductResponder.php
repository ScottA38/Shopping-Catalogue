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
        'price' => [FILTER_SANITIZE_NUMBER_FLOAT, ["flags" => FILTER_FLAG_ALLOW_FRACTION]],
        'dimensions' => [FILTER_SANITIZE_NUMBER_INT],
        'size' => [FILTER_SANITIZE_NUMBER_INT],
        'weight' => [FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION]
    ];

    /**
     * Function takes post array and
     */
    public static function processPost(): ?array
    {
        $filtered = [];
        assert($_POST, "No post variables to process!");

        foreach (array_keys($_POST) as &$paramKey) {
            if (!array_key_exists($paramKey, self::$sanitisationFilters)) {
                throw new \Exception("parameter key '$paramKey' does not have a matching sanitisation filter");
            } elseif (!array_key_exists($paramKey, self::$validationFilters)) {
                //var_dump(self::$validationFilters);
                throw new \Exception("parameter key '$paramKey' does not have a matching validation filter");
            }
            $filtered[$paramKey] = self::selectFilter($paramKey);
        }
        return $filtered;
    }

    protected static function filterInput($value, array $sanFilter, array $valFilter)
    {
        $temp = filter_var($value, ...$sanFilter);
        if ($temp === null) {
            throw new \Exception("Variable $paramKey failed sanitisation");
        }
        $temp = filter_var($value, ...$valFilter);
        if ($temp === null) {
            throw new \Exception("Variable $paramKey failed validation");
        }
        return $temp;
    }

    protected static function selectFilter(string $paramKey)
    {
        $sanFilter = self::$sanitisationFilters[$paramKey];
        $valFilter = self::$validationFilters[$paramKey];

        if (gettype($_POST[$paramKey]) === "array") {
            $filteredArray = [];
            for ($i = 0; $i < count($_POST[$paramKey]); $i++) {
                $filteredValue = self::filterInput($_POST[$paramKey][$i], $sanFilter, $valFilter);
                array_push($filteredArray, $filteredValue);
            }
            return $filteredArray;
        } else {
            return self::filterInput($_POST[$paramKey], $sanFilter, $valFilter);
        }
    }
}
