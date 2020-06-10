<?php

namespace DTOPHP\Parameter;

use \Reflector;

/**
 * Description of ExistInData
 *
 * @author Romário Beckman
 */
class GetDirectFromData extends AbstractParameter {

    public function handle(Reflector $reflector, $data) {
        if (isset($data[$reflector->getName()])) {
            return $data[$reflector->getName()];
        }

        return parent::handle($reflector, $data);
    }

}
