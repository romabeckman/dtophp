# dtophp

- Require php >= 7.1.0
- composer require romabeckman/dtophp

### Inject HTTP body in DTO

Use the abstract InDto class to inject the HTTP body into the DTO. __construct is not allowed to overwrite. Auto-inject the HTTP body and accept json. 

``` 
class UserInDto extends InDto {
    private $name;
    private $email;
    private $address;
    private $age;
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
    private $address;
    private $country;
    private $state;
    function getAddress(): string { return $this->address; }
    function getCountry(): string { return $this->country; }
    function getState(): string { return $this->state; }
    function setAddress(string $address): void { $this->address = $address; }
    function setCountry(string $country): void { $this->country = $country; }
    function setState(string $state): void { $this->state = $state; }
}

$userInDto = new UserInDto(); 
``` 

### Output DTO class

``` 
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

