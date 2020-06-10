<?php

namespace DTOPHP\Parameter;

use \Reflector;

/**
 * Description of AbstractType
 *
 * @author Romário Beckman
 */
class AbstractParameter implements Parameter {

    /**
     * @var ParameterInterface
     */
    private $nextType;

    /**
     * @param ParameterInterface $handler
     * @return ParameterInterface
     */
    public function setNext(Parameter $handler): Parameter {
        $this->nextType = $handler;
        return $handler;
    }

    /**
     *
     * @param string $request
     * @return mixed
     */
    public function handle(Reflector $reflector, array $data) {
        if ($this->nextType) {
            return $this->nextType->handle($reflector, $data);
        }

        return null;
    }

}
