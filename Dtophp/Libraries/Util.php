<?php

namespace Dtophp\Libraries;

use \ReflectionNamedType;
use \ReflectionProperty;

class Util {

    static private $inputs;

    static public function bodyHttp(?string $field = null): array {
        if (is_null(static::$inputs)) {
            $json = json_decode(file_get_contents('php://input'), true);
            static::$inputs = json_last_error() === JSON_ERROR_NONE ?
                    (array) $json :
                    (array) filter_input_array(INPUT_POST);
        }


        return is_null($field) ? static::$inputs : (static::$inputs[$field] ?? []);
    }

    static public function fixesByType(ReflectionNamedType $reflectionNamedType, $value) {
        switch ($reflectionNamedType->getName()) {
            case 'int':
                return is_int(filter_var($value, FILTER_VALIDATE_INT)) ? intval($value) : null;
            case 'bool':
                return is_int(filter_var($value, FILTER_VALIDATE_INT)) ? (bool) intval($value) : null;
            case 'float':
                return filter_var($value, FILTER_VALIDATE_FLOAT) ? floatval($value) : null;
            default:
                return $value;
        }
    }

    static public function attributeDocComment(string $documentation, string $tag): array {
        preg_match('/(?:\@' . $tag . ' )([a-zA-Z0-9_:.,|<>=-]+)/u', $documentation, $match);

        return isset($match[1]) ?
                explode('|', $match[1]) :
                [];
    }

    static public function paramByDocComment(string $documentation): array {
        $type = [];

        preg_match_all('/(?:\@param )((string|null|int|float|double|bool|array|\|)+) \$([a-zA-Z0-9]+)/u', $documentation, $match);

        if (isset($match[3])) {
            foreach ($match[3] as $index => $value) {
                $type[$value] = explode('|', $match[1][$index]);
            }
        }

        return $type;
    }

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

}
