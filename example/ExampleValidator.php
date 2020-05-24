<?php

use \Dtophp\OutputsInterface;
use \Dtophp\ValidatorInterface;

/**
 * @author Romário Beckman
 */
class ExampleValidator implements ValidatorInterface {

    /**
     * @param OutputsInterface $dto
     * @param array $rules
     * @return void
     */
    public function handlerDtoValidator(OutputsInterface $dto, array $rules): void {
        echo "Rules in " . get_class($dto) . ":<pre>";
        var_export($rules);
        echo "</pre><hr>";
    }

}
