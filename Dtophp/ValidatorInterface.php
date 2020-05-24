<?php

namespace Dtophp;

use \Dtophp\OutputsInterface;

/**
 * @author Romário Beckman
 */
interface ValidatorInterface {

    public function handlerDtoValidator(OutputsInterface $dto, array $rules): void;
}
