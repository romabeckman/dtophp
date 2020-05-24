<?php
require_once './vendor/autoload.php';

require_once './example/UserInDto.php';
require_once './example/AddressInDto.php';
require_once './example/ExampleValidator.php';

Dtophp\Configuration::setValidatorEngine('\ExampleValidator');
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="src/bootstrap.min.css" />

        <title>Example In Dto</title>
    </head>

    <body class="bg-light">

        <div class="container">
            <div class="py-5 text-center">
                <h2>Example</h2>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <form class="needs-validation" method="post">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="" value="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="" value="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="age">Age</label>
                                <input type="text" class="form-control" id="age" name="age" placeholder="" value="">
                            </div>
                        </div>
                        <h4 class="mb-3">Favorites foods</h4>
                        <div class="form-check">
                            <input type="checkbox" name="foods[]" class="form-check-input" id="foods-pizza" value="Pizza">
                            <label  class="form-check-label" for="foods-pizza"Pizza>Pizza</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="foods[]" class="form-check-input" id="foods-waffles" value="Waffles">
                            <label  class="form-check-label" for="foods-waffles">Waffles</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="foods[]" class="form-check-input" id="foods-hamburger" value="Hamburger">
                            <label  class="form-check-label" for="foods-hamburger">Hamburger</label>
                        </div>

                        <hr class="mb-4">

                        <h4 class="mb-3">Addres</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="address-address" name="address[address]" placeholder="" value="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email">Country</label>
                                <input type="text" class="form-control" id="country" name="address[country]" placeholder="" value="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="age">State</label>
                                <input type="text" class="form-control" id="state" name="address[state]" placeholder="" value="">
                            </div>
                        </div>

                        <hr class="mb-4">
                        <button class="btn btn-primary btn-lg btn-block" type="submit">Submit</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <h4 class="mb-3">DTO Objects filled with POST</h4>
                    <div class="jumbotron">
                        <?php
                        if (!empty($_POST)) {
                            $userInDto = new UserInDto();
                            ?>
                            <code>$userInDto = new UserInDto();</code><br><br>
                            <code>var_export($userInDto, true);</code>
                            <?php
                            echo '<pre>' . var_export($userInDto, true) . '</pre>';
                            ?>
                            <code>var_export($userInDto->toArray(), true);</code>
                            <?php
                            echo '<pre>' . var_export($userInDto->toArray(), true) . '</pre>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <hr class="mb-4">

            <div class="py-5 text-center">
                <h2>Class</h2>
            </div>
            <p>
                Use the abstract InDto class to inject the HTTP body into the DTO. <code>__construct</code> is not allowed to overwrite. It's accepted json.
            </p>
            <div class="jumbotron">
                <h4 class="mb-3">Class InDto</h4>
                <div class="row">
                    <div class="col-md-6">
                        <code>
                            use \Dtophp\InDto;<br>
                            class UserInDto extends InDto {<br>
                            /**<br>
                            * @rule required|max:255|min:5<br>
                            * @var string<br>
                            */<br>
                            private $name;<br>
                            /**<br>
                            * @rule required|email_address<br>
                            * @var string<br>
                            */<br>
                            private $email;<br>
                            /**<br>
                            * @rule required<br>
                            * @var AddressInDto<br>
                            */<br>
                            private $address;<br>
                            /**<br>
                            * @rule required|integer<br>
                            * @var int<br>
                            */<br>
                            private $age;<br>
                            /**<br>
                            * @rule required<br>
                            * @var array<br>
                            */<br>
                            private $foods;<br>
                            function getName(): string {<br>
                            return $this->name;<br>
                            }<br>
                            function getEmail(): string {<br>
                            return $this->email;<br>
                            }<br>
                            function getAddress(): AddressInDto {<br>
                            return $this->address;<br>
                            }<br>
                            function getAge(): int {<br>
                            return $this->age;<br>
                            }<br>
                            function getFoods(): array {<br>
                            return $this->foods;<br>
                            }<br>
                            function setName(string $name): void {<br>
                            $this->name = $name;<br>
                            }<br>
                            function setEmail(string $email): void {<br>
                            $this->email = $email;<br>
                            }<br>
                            function setAddress(AddressInDto $address): void {<br>
                            $this->address = $address;<br>
                            }<br>
                            function setAge(int $age): void {<br>
                            $this->age = $age;<br>
                            }<br>
                            function setFoods(array $foods): void {<br>
                            $this->foods = $foods;<br>
                            }<br>
                            }
                        </code>
                    </div>
                    <div class="col-md-6">
                        <code>
                            class AddressInDto extends InDto {<br>
                            /**<br>
                            * @rule required<br>
                            * @var string<br>
                            */<br>
                            private $address;<br>
                            /**<br>
                            * @rule required<br>
                            * @var string<br>
                            */<br>
                            private $country;<br>
                            /**<br>
                            * @rule required<br>
                            * @var string<br>
                            */<br>
                            private $state;<br>
                            function getAddress(): ?string {<br>
                            return $this->address;<br>
                            }<br>
                            function getCountry(): ?string {<br>
                            return $this->country;<br>
                            }<br>
                            function getState(): ?string {<br>
                            return $this->state;<br>
                            }<br>
                            function setAddress(string $address): void {<br>
                            $this->address = $address;<br>
                            }<br>
                            function setCountry(string $country): void {<br>
                            $this->country = $country;<br>
                            }<br>
                            function setState(string $state): void {<br>
                            $this->state = $state;<br>
                            }<br>
                            }
                        </code>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
