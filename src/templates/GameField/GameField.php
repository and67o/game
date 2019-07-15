<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Главная</title>
	<link rel="stylesheet" href="../../../dist/gameField.css">

</head>
<body>
<p>После закрытия этой страницы игра не сохранится</p>
<div class="game flex-center">
	<ul class="game__fields">
		<li class="game__fields__line">
			<p>1234</p>
			<span class="line-field"></span>
			<p>2x0</p>
		</li>
		<li class="game__fields__line">
			<p>1234</p>
			<span class="line-field"></span>
			<p>2x0</p>
		</li>
		<li class="game__fields__line">
			<p>1234</p>
			<span class="line-field"></span>
			<p>2x0</p>
		</li>
	</ul>

	<div class="game__new-number flex-center">
		<input type="text" class="game__new-number__field js-input-number" placeholder="Число" maxlength="4">
		<p class="error-field"></p>
		<button class="btn js-btn-go">Походить</button>
	</div>

</div>
<script src="../../../dist/gameField.js"></script>
</body>
</html>
