<?php

namespace Dtophp\Helpers;

use \Dtophp\Exception\DtoException;
use \Dtophp\OutputsInterface;
use \ReflectionClass;

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
    static public function json(OutputsInterface $instance): string {
        return json_encode(static::array($instance));
    }

    /**
     *
     * @param type $instance
     * @return array
     * @throws DtoException
     */
    static public function array(OutputsInterface $instance): array {
        $reflection = new ReflectionClass(get_class($instance));
        $data = [];

        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);

            $data[$property->getName()] = $property->getValue($instance);

            is_object($data[$property->getName()]) &&
                    $data[$property->getName()] = $data[$property->getName()]->toArray();
        }

        return $data;
    }

}
