<?php


namespace Router\src\classes\controller;

use Router\Models\Hash;
use Router\Models\Input;
use Router\Models\Session;
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
		if (!Input::isPostMethod()) {
			exit;
		}
		$data = Input::json(file_get_contents('php://input'));
		$email = (string) $data['email'];
		$password = (string) $data['password'];
		$salt = Hash::getSalt($email);
		if (!$salt) {
			$this->toJSON(['result' => false,], true);
		}
		$hashes = Hash::passwordHash($password, $salt);
		$Model = new model\Auth();
		$userId = $Model->checkEmailAndPassword($email, $hashes['hash']);
		if ($userId) {
			$this->setAuthCookie($userId);
		}
		$this->toJSON([
			'result' => (bool) $userId,
		], true);
	}
}
