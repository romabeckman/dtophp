<?php

namespace DTOPHP;

use \DTOPHP\Exception\DtoException;
use \ReflectionClass;

/**
 *
 * @author Romário Beckman
 */
trait OutputTrait {

    /**
     * @return string
     */
    public function __toString(): string {
        return $this->toJson();
    }

    /**
     *
     * @return string
     */
    final public function toJson(): string {
        return json_encode($this->toArray());
    }

    /**
     *
     * @return array
     */
    final public function toArray(): array {
        $reflection = new ReflectionClass(static::class);
        $data = [];

        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $data[$property->getName()] = $property->isInitialized($this) ? $property->getValue($this) : null;

            if (is_object($data[$property->getName()])) {
                $reflectionProperty = new ReflectionClass(get_class($data[$property->getName()]));

                if (empty($reflectionProperty->getInterfaceNames()) || in_array(OutputInterface::class, $reflectionProperty->getInterfaceNames()) === false) {
                    throw new DtoException('The class "' . $reflectionProperty->getName() . '" must implement "' . OutputInterface::class . '" interface.');
                }

                $data[$property->getName()] = $data[$property->getName()]->toArray();
            }
        }

        return $data;
    }

}
