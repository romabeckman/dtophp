<?php

namespace DTOPHP\Parameter;

use \Reflector;

interface Parameter {

    /**
     * @param \DTOPHP\Parameter\Parameter $handler
     * @return \DTOPHP\Parameter\Parameter
     */
    public function setNext(Parameter $handler): Parameter;

    /**
     * @param Reflector $reflector
     * @param array $data
     */
    public function handle(Reflector $reflector, array $data);
}
