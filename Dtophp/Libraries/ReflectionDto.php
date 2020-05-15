<?php

namespace Dtophp\Libraries;

use \Dtophp\Exception\DtoException;
use \Dtophp\InDto;
use \ReflectionClass;
use \ReflectionException;
use \ReflectionParameter;
use \UnexpectedValueException;

/**
 * Description of InDto
 *
 * @author Romário Beckman
 */
class ReflectionDto {

    static public function populateMethodsSet(InDto $instance, ?string $key = null): void {
        $reflection = new ReflectionClass(get_class($instance));

        foreach ($reflection->getProperties() as $properties) {
            if (isset(Util::bodyHttp($key)[$properties->name]) === false) {
                continue;
            }

            $name = 'set' . ucfirst($properties->name);
            try {
                $reflectionMethod = $reflection->getMethod($name);

                if ($reflectionMethod->getNumberOfParameters() === 0) {
                    throw new DtoException('The "' . $reflectionMethod->name . '" method must have parameter.');
                }

                $parameter = $reflectionMethod->getParameters()[0];
                $value = is_null($parameter->getClass()) ?
                        static::parameter($parameter, $key) :
                        static::newClass($parameter);

                if (is_null($value) === false) {
                    $reflectionMethod->invoke($instance, $value);
                }
            } catch (ReflectionException $ex) {
                throw new DtoException('Missing methods in the class:' . PHP_EOL . PHP_EOL . 'public function ' . $name . '($' . $properties->name . ') { $this->' . $properties->name . ' = $' . $properties->name . '; }' . PHP_EOL . PHP_EOL);
            }
        }
    }

    static private function newClass(ReflectionParameter $parameter): InDto {
        $reflection = new ReflectionClass($parameter->getClass()->name);
        if (is_null($reflection->getParentClass()) || $reflection->getParentClass()->name !== InDto::class) {
            throw new UnexpectedValueException('The class "' . $reflection->getName() . '" must extends abstract class "' . InDto::class . '".');
        }

        return $reflection->newInstance($parameter->name);
    }

    static private function parameter(ReflectionParameter $parameter, ?string $key) {
        $type = $parameter->getType();

        if (is_null($type)) {
            return Util::bodyHttp($key)[$parameter->name];
        }

        return Util::fixesByType($type, Util::bodyHttp($key)[$parameter->name]);
    }

}
