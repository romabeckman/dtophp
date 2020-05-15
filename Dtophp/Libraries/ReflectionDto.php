<?php

namespace Dtophp\Libraries;

use \Dtophp\Exception\DtoException;
use \Dtophp\InDto;
use \Dtophp\OutDto;
use \ReflectionClass;
use \ReflectionException;
use \ReflectionParameter;
use \UnexpectedValueException;

/**
 * Description
 *
 * @author Romário Beckman <romabeckman@gmail.com>
 */
class ReflectionDto {

    /**
     *
     * @param InDto $instance
     * @param string|null $key
     * @return void
     * @throws DtoException
     */
    static public function populate(InDto $instance, ?string $key = null): void {
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
                        static::newInClass($parameter);

                if (is_null($value) === false) {
                    $reflectionMethod->invoke($instance, $value);
                }
            } catch (ReflectionException $ex) {
                throw new DtoException('Missing methods in the class:' . PHP_EOL . PHP_EOL . 'public function ' . $name . '($' . $properties->name . ') { $this->' . $properties->name . ' = $' . $properties->name . '; }' . PHP_EOL . PHP_EOL);
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
            return Util::bodyHttp($key)[$parameter->name];
        }

        return Util::fixesByType($type, Util::bodyHttp($key)[$parameter->name]);
    }

    /**
     *
     * @param OutDto $instance
     * @return string
     */
    static public function json(OutDto $instance): string {
        return json_encode(static::array($instance));
    }

    /**
     *
     * @param OutDto $instance
     * @return array
     * @throws DtoException
     */
    static public function array(OutDto $instance): array {
        $reflection = new ReflectionClass(get_class($instance));
        $data = [];

        foreach ($reflection->getProperties() as $properties) {
            $name = 'get' . ucfirst($properties->name);

            try {
                $reflectionMethod = $reflection->getMethod($name);

                if (
                        is_null($reflectionMethod->getReturnType()) === false &&
                        $reflectionMethod->getReturnType()->isBuiltin() === false
                ) {
                    $data[$properties->name] = $reflectionMethod->invoke($instance)->toArray();
                } else {
                    $data[$properties->name] = $reflectionMethod->invoke($instance);
                }
            } catch (ReflectionException $ex) {
                throw new DtoException('Missing methods in the class:' . PHP_EOL . PHP_EOL . 'public function ' . $name . '() { return $this->' . $properties->name . '; }' . PHP_EOL . PHP_EOL);
            }
        }
        return $data;
    }

}
