<?php

use \DTOPHP\OutputInterface;
use \DTOPHP\ValidatorInterface;

/**
 * @author Romário Beckman
 */
class ExampleValidator implements ValidatorInterface {

    /**
     * @param OutputInterface $dto
     * @param array $rules
     * @return void
     */
    public function handlerDtoValidator(OutputInterface $dto, array $rules): void {
        echo "Rules in " . get_class($dto) . ":<pre>";
        var_export($rules);
        echo "</pre><hr>";
    }

}
