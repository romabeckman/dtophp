<?php

namespace Dtophp\Libraries;

use \Dtophp\Exception\DtoException;
use \Dtophp\InDto;
use \ReflectionClass;
use \ReflectionException;
use \ReflectionParameter;
use \UnexpectedValueException;

/**
 * This Class uses Reflection to populate or retrieve data of object.
 *
 * @author Romário Beckman <romabeckman@gmail.com>
 */
class ReflectionDto {

    /**
     * Populate object using "set" methods.
     *
     * Only one parameter will be accepted for "set" methods.
     *
     * @param InDto $instance
     * @param string|null $key
     * @return void
     * @throws DtoException
     */
    static public function populate(InDto $instance, ?string $key = null): void {
        $reflection = new ReflectionClass(get_class($instance));

        foreach ($reflection->getMethods() as $reflectionMethod) {
            if ($reflectionMethod->getNumberOfParameters() === 0 || stripos($reflectionMethod->getName(), 'set') !== 0) {
                continue;
            }

            if ($reflectionMethod->getNumberOfParameters() > 1) {
                throw new DtoException('The "' . $reflectionMethod->name . '" method must accept only 1 (one) parameter.');
            }

            $parameter = $reflectionMethod->getParameters()[0];

            if (isset(Util::data($key)[$parameter->name])) {
                $value = is_null($parameter->getClass()) ?
                        static::parameter($parameter, $key) :
                        static::newInClass($parameter);

                is_null($value) || $reflectionMethod->invoke($instance, $value);
            }
        }
    }

    /**
     *
     * @param ReflectionParameter $parameter
     * @return InDto
     * @throws UnexpectedValueException
     */
    static private function newInClass(ReflectionParameter $parameter): InDto {
        $reflection = new ReflectionClass($parameter->getClass()->name);
        if (is_null($reflection->getParentClass()) || $reflection->getParentClass()->name !== InDto::class) {
            throw new UnexpectedValueException('The class "' . $reflection->getName() . '" must extends abstract class "' . InDto::class . '".');
        }

        return $reflection->newInstance($parameter->name);
    }

    /**
     *
     * @param ReflectionParameter $parameter
     * @param string|null $key
     * @return type
     */
    static private function parameter(ReflectionParameter $parameter, ?string $key) {
        $type = $parameter->getType();

        if (is_null($type)) {
            return Util::data($key)[$parameter->name];
        }

        return Util::fixesByType($type, Util::data($key)[$parameter->name]);
    }

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
