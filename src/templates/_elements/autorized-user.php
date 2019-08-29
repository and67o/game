<header class="header">
	<?php
	/** @var string $path */
	/** @var string $email */
	if (isset($_COOKIE['userId']) && $email) {
		echo sprintf('<div class="authorized">
				<div class="authorized__profile">
					<a href="Profile" class="authorized__profile-name">%s</a>
					<p class="authorized__field js-log-out">Выход</p>
				</div>
				<a href="Profile"><img src="%s" alt="profile-avatar" class="authorized__avatar"></a>
			</div>', $email, $path);
		} else {
			echo '<div class="authorized">
				<p class="authorized__field js-register">Регистрация</p>
				<p class="authorized__field js-log-in">Вход</p>
			</div>';
		}
	?>
</header>

