<?php

use \DTOPHP\OutDto;

class UserOutDto extends OutDto {

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $email;

    /**
     * @var AddressOutDto
     */
    private $address;

    /**
     * @var int
     */
    private $age;

    /**
     * @var array
     */
    private $foods;

    function __construct(string $name, string $email, AddressOutDto $address, int $age, array $foods) {
        $this->name = $name;
        $this->email = $email;
        $this->address = $address;
        $this->age = $age;
        $this->foods = $foods;
    }

    function getName(): string {
        return $this->name;
    }

    function getEmail(): string {
        return $this->email;
    }

    function getAddress(): AddressOutDto {
        return $this->address;
    }

    function getAge(): int {
        return $this->age;
    }

    function getFoods(): array {
        return $this->foods;
    }

}
