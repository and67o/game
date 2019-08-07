<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $title ?></title>
	<link rel="stylesheet" href="../../../dist/mainPage.css">
</head>
<body>
<?php
	include 'src/templates/_elements/autorized-user.php';
?>
<div class="main-page flex-center">
	<ul class="main-page__variants">
		<li class="main-page__variants-list flex-center"><a href="Game">Игра</a><span class="angle"></span></li>
		<li class="main-page__variants-list flex-center"><a href="Statictics">Статистика</a></li>
		<li class="main-page__variants-list flex-center"><a href="Profile">Профиль</a></li>
	</ul>
</div>

<!--<div class="modal-container modal--opened">-->
<!--	<div class="modal">-->
<!--		<div class="modal__header">-->
<!--			<p class="modal__title">Слова</p>-->
<!--			<button class="js-close-modal">X</button>-->
<!--		</div>-->
<!--		<div class="modal__content"></div>-->
<!--		<div class="modal__footer">-->
<!--			<button class="btn">Ок</button>-->
<!--		</div>-->
<!--	</div>-->
<!--	<div class="modal__mask"></div>-->
<!--</div>-->
<script src="/dist/mainPage.js"></script>
</body>
</html>
