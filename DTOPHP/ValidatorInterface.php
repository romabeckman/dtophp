<?php

namespace DTOPHP;

use \DTOPHP\OutputInterface;

/**
 * @author Romário Beckman
 */
interface ValidatorInterface {

    public function handlerDtoValidator(OutputInterface $dto, array $rules): void;
}
