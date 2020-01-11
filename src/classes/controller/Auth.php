<?php


namespace Router\src\classes\controller;

use Router\src\classes\model;
use Router\src\classes\model\Input;
use Router\src\classes\model\services\Hash;

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
		if (!Input::isPostMethod()) {
			exit;
		}
		$data = Input::json(file_get_contents('php://input'));
		$email = (string) $data['email'];
		$password = (string) $data['password'];
		$salt = Hash::getSalt($email);
		if (!$salt) {
			$this->toJSON([
				'result' => false,
			], true);
		}
		$hashes = Hash::passwordHash($password, $salt);
		$userId = model\Auth::checkEmailAndPassword($email, $hashes['hash']);
		if ($userId) {
			model\Auth::setAuthCookie($userId);
		}
		$this->toJSON([
			'result' => (bool) $userId,
		], true);
	}
}
