<?php

namespace DTOPHP;

use \DTOPHP\Exception\ValidatorException;
use \DTOPHP\ValidatorInterface;
use \ReflectionClass;

/**
 *
 * @author Romário Beckman
 */
class Configuration {

    static private $validatorEngine;

    static function setValidatorEngine(string $validatorEngine): void {
        $reflection = new ReflectionClass($validatorEngine);

        if (in_array(ValidatorInterface::class, $reflection->getInterfaceNames()) === false) {
            throw new ValidatorException('The validator class must implements the "' . ValidatorInterface::class . '" interface.');
        }

        self::$validatorEngine = $validatorEngine;
    }

    static function getValidatorEngine(): ?string {
        return self::$validatorEngine;
    }

}
