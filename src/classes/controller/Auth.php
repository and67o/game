<?php


namespace Router\Controller;

use Router\Exceptions\BaseException;
use Router\Models\Auth as AuthModel;
use Router\Models\Services\{
	Session,
	Input,
	Hash
};


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
		try {
			$this->Input->setInputParam(
				file_get_contents('php://input'),
				Input::METHOD_REQUEST_POST
			);
			
			if (!$this->Input->checkRequestMethod()) {
				throw new BaseException(BaseException::WRONG_METHOD);
			}
			
			$email = $this->Input->get('email', 'string');
			$password = $this->Input->get('password', 'string');
			$salt = Hash::getSalt($email);
			if (!$salt) {
				throw new BaseException(BaseException::WRONG_AUTH);
			}
			
			$hashes = Hash::passwordHash($password, $salt);
			
			if ($password !== $hashes['hash']) {
				throw new BaseException(BaseException::USER_NOT_FOUND);
			}
			
			$userId = AuthModel::checkEmailAndPassword($email, $hashes['hash']);
			if (!$userId) {
				throw new BaseException(BaseException::USER_NOT_FOUND);
			}
			
			Session::set('user', $userId);
			AuthModel::setAuthCookie('userId', $userId);
			AuthModel::setAuthCookie('hash', $hashes['salt']);
			
			$this->toJSON(
				$this->response(
					[], (bool) $userId
				),
				true
			);
		} catch (BaseException $BaseException) {
			$this->toJSON(
				$this->response(
					[
						'default' => $BaseException->getTextError()
					],
					false
				), true
			);
		}
	}
}
