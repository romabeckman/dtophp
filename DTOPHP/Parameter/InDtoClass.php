<?php

namespace DTOPHP\Parameter;

use \DTOPHP\Exception\DtoException;
use \DTOPHP\InDto;
use \ReflectionClass;
use \Reflector;

/**
 * Description of DocCommentType
 *
 * @author Romário Beckman
 */
class InDtoClass extends AbstractParameter {

    /**
     * @param Reflector $reflector
     * @param array $data
     * @return type
     */
    public function handle(Reflector $reflector, array $data) {
        if (($reflector->hasType() && $reflector->getType()->isBuiltin() === false)) {
            $reflection = new ReflectionClass($reflector->getType()->getName());

            if (empty($reflection->getParentClass()) || $reflection->getParentClass()->getName() !== InDto::class) {
                throw new DtoException('The class "' . $reflection->getName() . '" must extends abstract class "' . InDto::class . '".');
            }

            return $reflection->newInstance($data[$reflector->getName()] ?? null);
        }

        return parent::handle($reflector, $data);
    }

}
