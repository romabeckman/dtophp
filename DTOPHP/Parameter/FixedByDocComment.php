<?php

namespace DTOPHP\Parameter;

use \DTOPHP\Helpers\Util;
use \Reflector;

/**
 * Description of DocCommentType
 *
 * @author Romário Beckman
 */
class FixedByDocComment extends AbstractParameter {

    /**
     * @param Reflector $reflector
     * @param array $data
     * @return type
     */
    public function handle(Reflector $reflector, array $data) {
        if ($document = $reflector->getDocComment()) {
            return Util::fixesByType(
                            Util::paramByDocComment($reflector->getDocComment()),
                            $data[$reflector->getName()]
            );
        }

        return parent::handle($reflector, $data);
    }

}
