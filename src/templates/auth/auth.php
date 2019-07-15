<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Авторизация</title>
	<link rel="stylesheet" href="../../../dist/auth.css">
</head>
<body>

<div class="auth flex-center">
	<div class="auth__email">
		<p class="auth__text">Email</p>
		<input class="auth__field js-auth-email" type="text" placeholder="Email" value="">
		<p class="error-field js-error-email"></p>
	</div>
	<div class="auth__password">
		<p class="auth__text">Пароль</p>
		<input class="auth__field js-auth-password" type="password" placeholder="Пароль" value="">
		<p class="error-field js-error-password"></p>
	</div>
	<button class="btn js-btn-auth">Вход</button>
</div>
<script src="../../../dist/auth.js"></script>
</body>
</html>
