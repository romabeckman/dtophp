<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Dtophp;

/**
 *
 * @author Romário Beckman
 */
interface OutputsInterface {

    public function toJson(): string;

    public function toArray(): array;
}
