<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>Example Out Dto</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>

    <body class="bg-light">

        <div class="container">
            <div class="py-5 text-center">
                <h2>Example</h2>
            </div>

            <div class="jumbotron">
                <code>
                    $addressOutDto = new AddressOutDto('Av. Dr. Heitor Penteado', 'Brazil', 'São Paulo');<br />
                    $userOutDto = new UserOutDto('My Name', 'my_email@test.com', $addressOutDto, 30, ['Hamburger', 'Pizza']);<br><br>
                    var_export($userOutDto->toArray());</br>
                    //print array ( 'name' => 'My Name', 'email' => 'my_email@test.com', 'address' => array ( 'address' => 'Av. Dr. Heitor Penteado', 'country' => 'Brazil', 'state' => 'São Paulo', ), 'age' => 30, 'foods' => array ( 0 => 'Hamburger', 1 => 'Pizza', ), )<br></br>
                    var_export($userOutDto->toJson());
                    //print '{"name":"My Name","email":"my_email@test.com","address":{"address":"Av. Dr. Heitor Penteado","country":"Brazil","state":"S\\u00e3o Paulo"},"age":30,"foods":["Hamburger","Pizza"]}'
                </code>
            </div>

            <div class="py-5 text-center">
                <h2>Class</h2>
            </div>
            <p>
                Use the abstract in Dto class to output in array or json.
            </p>
            <div class="jumbotron">
                <h4 class="mb-3">Class InDto</h4>
                <div class="row">
                    <div class="col-md-6">
                        <code>
                            use \Dtophp\OutDto;<br><br>
                            class UserOutDto extends OutDto {<br><br>
                            private $name;<br>
                            private $email;<br>
                            private $address;<br>
                            private $age;<br>
                            private $foods;<br><br>
                            function __construct(string $name, string $email, AddressOutDto $address, int $age, array $foods) {<br>
                            $this->name = $name;<br>
                            $this->email = $email;<br>
                            $this->address = $address;<br>
                            $this->age = $age;<br>
                            $this->foods = $foods;<br>
                            }<br><br>
                            function getName(): string {<br>
                            return $this->name;<br>
                            }<br><br>
                            function getEmail(): string {<br>
                            return $this->email;<br>
                            }<br><br>
                            function getAddress(): AddressOutDto {<br>
                            return $this->address;<br>
                            }<br><br>
                            function getAge(): int {<br>
                            return $this->age;<br>
                            }<br><br>
                            function getFoods(): array {<br>
                            return $this->foods;<br>
                            }<br><br>
                            }
                        </code>
                    </div>
                    <div class="col-md-6">
                        <code>
                            use \Dtophp\OutDto;<br><br>
                            class AddressOutDto extends OutDto {<br><br>
                            private $address;<br>
                            private $country;<br>
                            private $state;<br><br>
                            function __construct(string $address, string $country, string $state) {<br>
                            $this->address = $address;<br>
                            $this->country = $country;<br>
                            $this->state = $state;<br>
                            }<br><br>
                            function getAddress(): string {<br>
                            return $this->address;<br>
                            }<br><br>
                            function getCountry(): string {<br>
                            return $this->country;<br>
                            }<br><br>
                            function getState(): string {<br>
                            return $this->state;<br>
                            }<br><br>
                            }
                        </code>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
