<?php

namespace DTOPHP\Parameter;

use \DTOPHP\Helpers\Util;
use \Reflector;

/**
 * Description of HasTypeHandler
 *
 * @author Romário Beckman
 */
class FixedByReflectorType extends AbstractParameter {

    public function handle(Reflector $reflector, $data) {
        if ($reflector->hasType()) {
            return Util::fixesByType($reflector->getType()->getName(), $data[$reflector->getName()]);
        }

        return parent::handle($reflector, $data);
    }

}
