# dtophp

- Require php >= 7.1.0
- composer require romabeckman/dtophp

### Inject HTTP body in DTO

Use the abstract InDto class to inject the HTTP body into the DTO. __construct is not allowed to overwrite. Auto-inject the HTTP body and accept json. 

```php
class UserInDto extends InDto {
    /**
     * @rule required|max:255|min:5
     * @var string
     */
    private $name;
    /**
     * @rule required|email_address
     * @var string
     */
    private $email;
    /**
     * @rule required
     * @var AddressInDto
     */
    private $address;
    /**
     * @rule required|integer
     * @var int
     */
    private $age;
    /**
     * @rule required
     * @var array
     */
    private $foods;
    function getName(): string { return $this->name; }
    function getEmail(): string { return $this->email; }
    function getAddress(): AddressInDto { return $this->address; }
    function getAge(): int { return $this->age; }
    function getFoods(): array { return $this->foods; }
    function setName(string $name): void { $this->name = $name; }
    function setEmail(string $email): void { $this->email = $email; }
    function setAddress(AddressInDto $address): void { $this->address = $address; }
    function setAge(int $age): void { $this->age = $age; }
    function setFoods(array $foods): void { $this->foods = $foods; }
}

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
    function getAddress(): string { return $this->address; }
    function getCountry(): string { return $this->country; }
    function getState(): string { return $this->state; }
    function setAddress(string $address): void { $this->address = $address; }
    function setCountry(string $country): void { $this->country = $country; }
    function setState(string $state): void { $this->state = $state; }
}

// The constructor will populate HTTP Body into Object
$userInDto = new UserInDto(); 
``` 

### Validation (example in Laravel)

The Validator requires DocComment on attribute. You must use tag *@rule*. To configure the validator you must call static method, like exemple:

```php
//Configuring class to validation
Dtophp\Configuration::setValidatorEngine('MyNameSpace\To\LaravelValidator');
```

Below the class that will perform the validation. Important, the class must be implemented in your application. And, It´s required implements ``ValidatorInterface`` interface.
```php
class LaravelValidator implements ValidatorInterface {

    /**
     * @param OutputsInterface $dto
     * @param array $rules
     * @return void
     */
    public function handlerDtoValidator(OutputsInterface $dto, array $rules): void {
        $validator = Validator::make($dto->toArray(), $rules);

        if ($validator->fails()) {
            Response::make()
                    ->create($validator->errors()->all(), 400)
                    ->send();
            exit;
        }
    }

}
```

### Output DTO class

```php
class UserOutDto extends OutDto {
    private $name;
    private $email;
    private $address;
    private $age;
    private $foods;
    function __construct(string $name, string $email, AddressOutDto $address, int $age, array $foods) {
        $this->name = $name;
        $this->email = $email;
        $this->address = $address;
        $this->age = $age;
        $this->foods = $foods;
    }
    function getName(): string { return $this->name; }
    function getEmail(): string { return $this->email; }
    function getAddress(): AddressOutDto { return $this->address; }
    function getAge(): int { return $this->age; }
    function getFoods(): array { return $this->foods; }
}

class AddressOutDto extends OutDto {
    private $address;
    private $country;
    private $state;
    function __construct(string $address, string $country, string $state) {
        $this->address = $address;
        $this->country = $country;
        $this->state = $state;
    }
    function getAddress(): string { return $this->address; }
    function getCountry(): string { return $this->country; }
    function getState(): string { return $this->state; }
}

$addressOutDto = new AddressOutDto('Av. Dr. Heitor Penteado', 'Brazil', 'São Paulo');
$userOutDto = new UserOutDto('My Name', 'my_email@test.com', $addressOutDto, 30, ['Hamburger', 'Pizza']);

var_export($userOutDto->toArray());
//print array ( 'name' => 'My Name', 'email' => 'my_email@test.com', 'address' => array ( 'address' => 'Av. Dr. Heitor Penteado', 'country' => 'Brazil', 'state' => 'São Paulo', ), 'age' => 30, 'foods' => array ( 0 => 'Hamburger', 1 => 'Pizza', ), )

var_export($userOutDto->toJson()); //print '{"name":"My Name","email":"my_email@test.com","address":{"address":"Av. Dr. Heitor Penteado","country":"Brazil","state":"S\\u00e3o Paulo"},"age":30,"foods":["Hamburger","Pizza"]}' 
``` 

