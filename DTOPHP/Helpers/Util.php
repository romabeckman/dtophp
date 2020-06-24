<?php

namespace DTOPHP\Helpers;

use \ReflectionNamedType;
use \ReflectionProperty;

/**
 * Description
 *
 * @author Romário Beckman <romabeckman@gmail.com>
 */
class Util {

    /**
     * @return array
     */
    static public function getData(): array {
        $data = json_decode(file_get_contents('php://input'), true);

        if (json_last_error() === JSON_ERROR_NONE) {
            return (array) $data;
        }

        $data = (array) filter_input_array(INPUT_POST);
        if (!empty($data)) {
            return $data;
        }

        return (array) filter_input_array(INPUT_GET);
    }

    /**
     *
     * @param ReflectionNamedType $reflectionNamedType
     * @param type $value
     * @return type
     */
    static public function fixesByType(string $type, $value) {
        switch ($type) {
            case 'int':
                return is_int(filter_var($value, FILTER_VALIDATE_INT)) ? intval($value) : null;
            case 'bool':
                return is_int(filter_var($value, FILTER_VALIDATE_INT)) ? (bool) intval($value) : null;
            case 'float':
                return filter_var($value, FILTER_VALIDATE_FLOAT) ? floatval($value) : null;
            case 'array':
                return filter_var($value, FILTER_DEFAULT, FILTER_REQUIRE_ARRAY) ?: null;
            case 'string':
                return is_string($value) ? $value : null;
            default:
                return $value;
        }
    }

    /**
     *
     * @param string $documentation
     * @param string $tag
     * @return array
     */
    static public function attributeDocComment(string $documentation, string $tag): array {
        preg_match('/(?:\@' . $tag . ' )([a-zA-Z0-9_:.,|<>=\-\[\]\(\)\{\};]+)/u', $documentation, $match);

        return isset($match[1]) ?
                explode('|', $match[1]) :
                [];
    }

    /**
     *
     * @param string $documentation
     * @return array
     */
    static public function paramByDocComment(string $documentation): string {
        preg_match('/(?:\@(param|var)) ((string|int|float|double|bool|array)|\||null)+/u', $documentation, $match);
        return $match[3] ?? '';
    }

    /**
     *
     * @param ReflectionProperty $property
     * @param type $value
     * @return type
     */
    static public function fixesTypeByDocComment(ReflectionProperty $property, $value) {
        $type = static::attributeDocComment($property->getDocComment(), 'var');
        $type = array_flip($type);

        switch (true) {
            case isset($type['int']):
                return intval($value);
            case isset($type['bool']):
                return (bool) intval($value);
            case isset($type['float']):
                return floatval($value);
            default:
                return $value;
        }
    }

    /**
     *
     * @param ReflectionProperty $property
     * @param type $value
     * @return bool
     */
    static public function matchTypeByDocComment(ReflectionProperty $property, $value): bool {
        $type = static::attributeDocComment($property->getDocComment(), 'var');
        $type = array_flip($type);

        switch (true) {
            case isset($type['int']) || isset($type['bool']):
                return is_int(filter_var($value, FILTER_VALIDATE_INT));
            case isset($type['float']):
                return filter_var($value, FILTER_VALIDATE_FLOAT);
            case isset($type['array']):
                return is_array($value);
            case isset($type['string']):
                return is_string($value);
            default:
                return true;
        }
    }

    /**
     * @param string $name
     * @return string
     */
    static public function toPascalCase(string $name): string {
        return preg_replace('/[_-]/u', '', ucwords($name, " \t\r\n\f\v_-"));
    }

}
