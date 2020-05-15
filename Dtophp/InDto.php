<?php

namespace Dtophp;

use \Dtophp\Libraries\ReflectionDto;

abstract class InDto {

    final public function __construct(?string $_ = null) {
        ReflectionDto::populateMethodsSet($this, $_);
    }

}
