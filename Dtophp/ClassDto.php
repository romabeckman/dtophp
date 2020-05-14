<?php

namespace Dtophp;

use \BadMethodCallException;
use \ReflectionClass;

class ClassDto
{

    /**
     *
     * @var string
     */
    private $class;

    /**
     *
     * @var ReflectionClass
     */
    private $reflection;

    /**
     *
     * @param string $class
     * @throws BadMethodCallException
     */
    public function __construct(string $class)
    {
        if (class_exists($class, true) === false) {
            throw new BadMethodCallException('Class "' . $class . '" do not exists.');
        }

        $this->class = $class;
        $this->reflection = new ReflectionClass($class);
    }

    public function getReflection(): ReflectionClass
    {
        return $this->reflection;
    }

    public function getClass(): string
    {
        return $this->class;
    }

}
