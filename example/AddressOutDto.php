<?php

use \DTOPHP\OutDto;

class AddressOutDto extends OutDto {

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $state;

    function __construct(string $address, string $country, string $state) {
        $this->address = $address;
        $this->country = $country;
        $this->state = $state;
    }

    function getAddress(): string {
        return $this->address;
    }

    function getCountry(): string {
        return $this->country;
    }

    function getState(): string {
        return $this->state;
    }

}
