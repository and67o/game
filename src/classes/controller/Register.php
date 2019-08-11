<?php


namespace Router\src\classes\controller;



use Router\Models\User;

/**
 * Класс отвечающий за регистрацию
 * Class Register
 */
class Register extends CommonController
{
	/**
	 * Регистрация пользователя
	 */
	public function register()
	{
		$email = (string)$_POST['email'];
		$password = (string)$_POST['password'];
		$isEmailExist = User::isEmailExist($email);
		if ($isEmailExist) {
			$this->toJSON([
				'result' => false,
				'error' => 'Email занят'
			], true);
		}
		$userId = User::createNewUser($email, $password);
		if ($userId) {
			$this->setAuthCookie($userId);
		}
		$this->toJSON([
			'result' => (bool) $userId,
		], true);
	}
}
