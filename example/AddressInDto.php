<?php

use \Dtophp\InDto;

class AddressInDto extends InDto {

    /**
     * @rule required
     * @var string
     */
    private $address;

    /**
     * @rule required
     * @var string
     */
    private $country;

    /**
     * @rule required
     * @var string
     */
    private $state;

    function getAddress(): ?string {
        return $this->address;
    }

    function getCountry(): ?string {
        return $this->country;
    }

    function getState(): ?string {
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
