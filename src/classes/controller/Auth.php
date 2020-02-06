<?php


namespace Router\Controller;

use Router\Models\Services\Hash;
use Router\Models\Services\Input;
use Router\Model\Auth as AuthModel;


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
		$userId = AuthModel::checkEmailAndPassword($email, $hashes['hash']);
		if ($userId) {
			AuthModel::setAuthCookie($userId);
		}
		$this->toJSON([
			'result' => (bool) $userId,
		], true);
	}
}
