<?php

namespace DTOPHP;

use \DTOPHP\OutputsInterface;

/**
 * @author Romário Beckman
 */
interface ValidatorInterface {

    public function handlerDtoValidator(OutputsInterface $dto, array $rules): void;
}
