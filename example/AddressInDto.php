<?php

use \Dtophp\InDto;

class AddressInDto extends InDto {

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

    function getAddress(): string {
        return $this->address;
    }

    function getCountry(): string {
        return $this->country;
    }

    function getState(): string {
        return $this->state;
    }

    function setAddress(string $address): void {
        $this->address = $address;
    }

    function setCountry(string $country): void {
        $this->country = $country;
    }

    function setState(string $state): void {
        $this->state = $state;
    }

}
