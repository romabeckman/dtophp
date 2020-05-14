<?php

namespace Dtophp;

abstract class AbstractDto
{

    abstract static public function acceptIn(): bool;

    abstract static public function acceptOut(): bool;
}
