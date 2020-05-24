<?php

namespace Dtophp\Helpers;

use \Dtophp\Exception\DtoException;
use \ReflectionClass;
use \ReflectionException;

/**
 * This Class uses Reflection to populate or retrieve data of object.
 *
 * @author Romário Beckman <romabeckman@gmail.com>
 */
class Output {

    /**
     *
     * @param type $instance
     * @return string
     */
    static public function json($instance): string {
        return json_encode(static::array($instance));
    }

    /**
     *
     * @param type $instance
     * @return array
     * @throws DtoException
     */
    static public function array($instance): array {
        $reflection = new ReflectionClass(get_class($instance));
        $data = [];

        foreach ($reflection->getMethods() as $reflectionMethod) {
            if (stripos($reflectionMethod->getName(), 'get') !== 0) {
                continue;
            }

            $name = lcfirst(substr($reflectionMethod->getName(), 3));
            try {
                $property = $reflection->getProperty($name);
                $property->setAccessible(true);
                if (is_null($property->getValue($instance))) {
                    $data[$name] = null;
                    continue;
                }
            } catch (ReflectionException $ex) {
                throw new DtoException('The method name "' . $reflectionMethod->getName() . '" does not match any attibutes in the "' . $reflection->getName() . '" class. Attribute name "$' . $name . '" does not exist.');
            }

            $returnType = $reflectionMethod->getReturnType();

            if (is_null($returnType) === false && $returnType->isBuiltin() === false) {
                $data[$name] = $reflectionMethod->invoke($instance)->toArray();
            } else {
                $data[$name] = $reflectionMethod->invoke($instance);
            }
        }
        return $data;
    }

}
