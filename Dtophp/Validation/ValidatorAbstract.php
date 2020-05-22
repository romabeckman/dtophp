<?php

namespace Dtophp\Validation;

use \Dtophp\OutputsInterface;

/**
 * @author Romário Beckman
 */
abstract class ValidatorAbstract implements ValidatorInterface {

    /**
     * @var array
     */
    private $rules;

    /**
     * @var OutputsInterface
     */
    private $dto;

    /**
     * @param array $rules
     */
    public function __construct(OutputsInterface $dto, array $rules) {
        $this->rules = $rules;
        $this->dto = $dto;
    }

    /**
     * @return array
     */
    function getRules(): array {
        return $this->rules;
    }

    function getDto(): OutputsInterface {
        return $this->dto;
    }

}
