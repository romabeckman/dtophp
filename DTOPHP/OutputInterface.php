<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DTOPHP;

/**
 *
 * @author Romário Beckman
 */
interface OutputInterface {

    public function __toString(): string;

    public function toJson(): string;

    public function toArray(): array;
}
