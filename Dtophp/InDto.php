<?php

namespace Dtophp;

use \Dtophp\Libraries\ReflectionDto;

/**
 * This class populate data by Body HTTP.
 *
 * The __construct is not allowed to overwrite. For populate data, there must have exists "set" methods.
 * Only one parameter will be accepted for "set" methods.
 *
 * @author Romário Beckman <romabeckman@gmail.com>
 */
abstract class InDto implements OutputsInterface {

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
