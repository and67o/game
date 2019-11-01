<?php


namespace Router\src\classes\controller;

use Router\Models\Input;
use Router\src\classes\interfaces\AuthInterface;
use Router\src\classes\model;

/**
 * Класс отвечающией за авторизацию
 * Class Auth
 */
class Auth extends CommonController implements AuthInterface
{
	/**
	 * Авторизация на сайте
	 */
	public function authorisation()
	{
		$email = (string) Input::get('email');
		$password = (string) Input::get('password');
		$Model = new model\Auth();
		$userId = $Model->checkEmailAndPassword($email, $password);
		if ($userId) {
			$this->setAuthCookie($userId);
		}
		$this->toJSON([
			'result' => (bool) $userId,
		], true);
	}
}
