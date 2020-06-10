<?php

use \DTOPHP\InDto;

class UserInDto extends InDto {

    /**
     * @rule required|max:255|min:5
     * @var string
     */
    private string $name;

    /**
     * @rule required|email_address
     * @var string
     */
    private string $email;

    /**
     * @rule required
     * @var AddressInDto
     */
    private AddressInDto $address;

    /**
     * @rule required|integer
     * @var int
     */
    private int $age;

    /**
     * @rule required
     * @var array
     */
    private array $foods;

    function getName(): string {
        return $this->name;
    }

    function getEmail(): string {
        return $this->email;
    }

    function getAddress(): AddressInDto {
        return $this->address;
    }

    function getAge(): int {
        return $this->age;
    }

    function getFoods(): array {
        return $this->foods;
    }

    function setName(string $name): void {
        $this->name = $name;
    }

    function setEmail(string $email): void {
        $this->email = $email;
    }

    function setAddress(AddressInDto $address): void {
        $this->address = $address;
    }

    function setAge(int $age): void {
        $this->age = $age;
    }

    function setFoods(array $foods): void {
        $this->foods = $foods;
    }

}
