<?php


namespace Router\src\classes\controller;

use Router\src\classes\model;

/**
 * Класс отвечающией за авторизацию
 * Class Auth
 */
class Auth extends CommonController
{
	/**
	 * Авторизация на сайте
	 */
	public function authorisation()
	{
		$email = (string)$_POST['email'];
		$password = (string)$_POST['password'];
		$userId = model\Auth::checkEmailAndPassword($email, $password);
		if ($userId) {
			$this->setAuthCookie($userId);
		}
		$this->toJSON([
			'result' => (bool) $userId,
		], true);
	}
}
