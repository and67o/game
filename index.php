
<?php

use Router\Router;

require_once 'vendor/autoload.php';
ini_set('display_errors', 1);

$Router = new Router();
$Router->run();
?>
<!---->
<!--<!DOCTYPE html>-->
<!--<html lang="en">-->
<!--<head>-->
<!--	<meta charset="UTF-8">-->
<!--	<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
<!--	<meta http-equiv="X-UA-Compatible" content="ie=edge">-->
<!--	<title>Route Map</title>-->
<!--	<link rel="stylesheet" href="dist/index.css">-->
<!--</head>-->
<!--<body>-->
<!--	<div class="route">-->
<!--		<div class="route__check-points">-->
<!--			<div class="address-field">-->
<!--				<input id="add-new-point" class="address-field__input" type="text" required>-->
<!--				<label for="add-new-point" class="address-field__label">Новая точка маршрута</label>-->
<!--			</div>-->
<!--			<ul id="address-list" class="address-list">-->
<!--			</ul>-->
<!--		</div>-->
<!--		<div id="map" class="route__map"></div>-->
<!--	</div>-->
<!--	<script src="https://api-maps.yandex.ru/2.1/?apikey=21f5935c-9219-4f9a-8ca6-392147198c36&lang=ru_RU"></script>-->
<!--	<script src="dist/index.js"></script>-->
<!--</body>-->
<!--</html>-->
