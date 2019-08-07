<?php


namespace Router\src\classes\controller;

use Router\src\classes\model;

/**
 * Класс отвечающией за авторизацию
 * Class Auth
 * @package Router\src\classes\controller
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
			setcookie('userId', $userId, strtotime( '+30 days' ), '/');
		}
		$this->toJSON([
			'result' => (bool) $userId,
		], true);
	}
}
