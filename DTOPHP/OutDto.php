<?php

namespace DTOPHP;

use \DTOPHP\Helpers\Output;

/**
 * Description
 *
 * @author Romário Beckman <romabeckman@gmail.com>
 */
abstract class OutDto implements OutputsInterface {

    /**
     *
     * @return string
     */
    final public function toJson(): string {
        return Output::json($this);
    }

    /**
     *
     * @return array
     */
    final public function toArray(): array {
        return Output::array($this);
    }

    /**
     * @return string
     */
    public function __toString(): string {
        return $this->toJson();
    }

}