<?php

require_once './vendor/autoload.php';
require_once './example/EnderecoOutDto.php';
require_once './example/UsuarioOutDto.php';

echo '<pre>';

$enderecoOutDto = new EnderecoOutDto('Cidade Nova 5', '712', 'Coqueiro', 'Ananindeua', 'PA');

$UsuarioDto = new UsuarioOutDto('Romário', 'Beckman', 'romabeckman@gmail.com', $enderecoOutDto, 33, ['Lasanha', 'Macarronada']);

var_export($UsuarioDto->toArray());
var_export($UsuarioDto->toJson());
?>