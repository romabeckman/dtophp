<?php

namespace Dtophp;

use \Dtophp\Libraries\ReflectionDto;

/**
 * Description
 *
 * @author Romário Beckman <romabeckman@gmail.com>
 */
abstract class InDto {

    /**
     *
     * @param string|null $_
     */
    final public function __construct(?string $_ = null) {
        ReflectionDto::populate($this, $_);
    }

    /**
     *
     * @return string
     */
    final public function toJson(): string {
        return ReflectionDto::json($this);
    }

    /**
     *
     * @return array
     */
    final public function toArray(): array {
        return ReflectionDto::array($this);
    }

}
