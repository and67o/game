<?php


namespace Router\Controller;

use Router\Exceptions\BaseException;
use Router\Models\Auth as AuthModel;
use Router\Models\Services\{
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
			$this->setRequest(Input::METHOD_REQUEST_POST);

			$email = $this->Input->get('email', 'string');
			$password = $this->Input->get('password', 'string');
			$userParam = Hash::getPasswordParam($email);
			$salt = $userParam['salt'];
			
			if (!$salt) {
				throw new BaseException(BaseException::WRONG_AUTH);
			}
			
			$hashes = Hash::passwordHash($password, $salt);
			
			$userId = (int) AuthModel::checkEmailAndPassword($email, $hashes['hash']);
			if (
				!$userId &&
				$userParam['password'] !== $hashes['hash']
			) {
				throw new BaseException(BaseException::USER_NOT_FOUND);
			}
			
			$this->setAuthParam($userId, $hashes['salt']);
			
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
	
	/**
	 * @param $userId
	 * @param $salt
	 * @return void
	 */
	private function setAuthParam(int $userId, string $salt)
	{
		$this->Session->set('userId', $userId);

		AuthModel::setAuthCookie('userId', $userId);
		AuthModel::setAuthCookie('hash', $salt);
	}
	
	/**
	 * Выход
	 */
	public function logOut() {
		$this->Session->delete('userId');
		setcookie("userId", "", time() - 3600);
		setcookie("hash", "", time() - 3600);
	}
}
