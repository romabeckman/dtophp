<?php

namespace DTOPHP\Parameter;

use \Reflector;

/**
 * Description of ExistInData
 *
 * @author Romário Beckman
 */
class ParameterNotExistInData extends AbstractParameter {

    public function handle(Reflector $reflector, $data) {
        if (isset($data[$reflector->getName()]) === false) {
            return null;
        }

        return parent::handle($reflector, $data);
    }

}
