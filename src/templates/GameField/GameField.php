<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $title ?></title>
	<link rel="stylesheet" href="../../../dist/gameField.css">
</head>
<body>
<div class="game flex-center">
	<ul class="game__fields">
		<?php
			foreach ($moves as $move) {
				echo sprintf(
			'<li class="game__fields__line">
						<p>%s</p>
						<span class="line-field"></span>
						<p>%sx%s</p>
					</li>'
			, $move['move'], $move['right_count'], $move['right_position']
				);
			}
		?>
	</ul>
	<div class="game__new-number flex-center">
		<input type="text" class="game__new-number__field js-input-number" placeholder="Число" maxlength="4">
		<p class="error-field"></p>
		<button class="btn btn-go js-btn-go">Походить</button>
	</div>

</div>
<script src="../../../dist/gameField.js"></script>
</body>
</html>
