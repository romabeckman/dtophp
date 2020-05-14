<?php

namespace Dtophp;

use \BadMethodCallException;
use \ReflectionClass;
use \ReflectionException;
use \ReflectionMethod;
use \ReflectionProperty;
use \UnexpectedValueException;

/**
 * Description of InDto
 *
 * @author Romário Beckman
 */
class InDto
{

    /**
     *
     * @var ReflectionClass
     */
    private $reflection;

    /**
     *
     * @var AbstractDto
     */
    private $instance;

    /**
     *
     * @var array
     */
    private $inputs = [];

    function __construct(string $class, array $inputs)
    {
        if (class_exists($class, true) === false) {
            throw new BadMethodCallException('Class "' . $class . '" do not exists.');
        }

        $this->reflection = new ReflectionClass($class);
        $this->inputs = $inputs;
        $this->newInstance();
        $this->populateMethodsSet();
    }

    private function newInstance(): void
    {
        if ($this->reflection->getParentClass()->name !== AbstractDto::class) {
            throw new UnexpectedValueException('The class "' . $this->class . '" must extends abstract class "' . AbstractDto::class . '".');
        }

        $constructor = $this->reflection->getConstructor();
        if ($this->reflection->getName()::acceptIn() && !is_null($constructor) && $constructor->getNumberOfRequiredParameters() > 0) {
            throw new DtoException('When the "acceptIn()" method returns "true" the "__construct" must not have any required parameters. Remove the "__construct" or make it optional.');
        }
        if ($this->reflection->getName()::acceptIn() === false) {
            throw new DtoException('The "' . $this->class . '" class not allowed.');
        }

        $this->instance = $this->reflection->newInstance();
    }

    private function populateMethodsSet(): void
    {
        foreach ($this->reflection->getProperties() as $properties) {
            if (!isset($this->inputs[$properties->name])) {
                continue;
            }

            $name = 'set' . ucfirst($properties->name);
            try {
                $methotSet = $this->reflection->getMethod($name);
                $methotSet->invoke($this->instance, $this->parameter($methotSet));
            } catch (ReflectionException $ex) {
                throw new DtoException('Missing methods in the class:' . PHP_EOL . PHP_EOL . 'public function ' . $name . '($' . $properties->name . ') { $this->' . $properties->name . ' = $' . $properties->name . '; }' . PHP_EOL . PHP_EOL);
            }
        }
    }

    private function parameter(ReflectionMethod $reflectionMethod)
    {
        if ($reflectionMethod->getNumberOfParameters() === 0) {
            throw new DtoException('The "' . $reflectionMethod->name . '" method must have parameter.');
        }

        $parameter = $reflectionMethod->getParameters()[0];
        $newClass = $parameter->getClass();
        if (is_null($newClass)) {
            $type = $parameter->getType();

            if (is_null($type)) {
                throw new UnexpectedValueException('The "' . $reflectionMethod->name . '" method must have type in parameter.');
            }

            $value = Util::fixesByType($type, $this->inputs[$parameter->name]);

            if ($type->allowsNull() === false && is_null($value)) {
                throw new UnexpectedValueException('The "$' . $parameter->getName() . '" parameter in the "' . $reflectionMethod->name . '" method must be of the type null.');
            }

            return $value;
        } else {
            $reflection = new InDto($newClass->name, $this->inputs[$parameter->name] ?? []);
            return $reflection->getInstance();
        }
    }

    private function validateProperty(ReflectionProperty $property, $value): bool
    {
        if (empty($property->getDocComment())) {
            throw new DtoException('The documentation is missing in attribute "$' . $property->name . '". Example: "/** @var string */');
        }

        $var = Util::attributeDocComment($property->getDocComment(), 'var');

        if (empty($var)) {
            throw new DtoException('The tag "@var" not found in attribute "$' . $property->name . '". Example: "@var string".');
        }

        if (Util::matchByType($property, $value) === false) {
            throw new DtoException('The attribute "$' . $property->name . '".');
        }

        return Util::matchByType($value, $var);
    }

    function getInstance(): ?AbstractDto
    {
        return $this->instance;
    }

}
