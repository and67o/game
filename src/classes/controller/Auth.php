<?php


namespace Router\Controller;

use Exception;
use Router\Models\Services\Hash;
use Router\Models\Services\Input;
use Router\Models\Auth as AuthModel;


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
            if (!Input::isPostMethod()) throw new Exception('не тот метод');
    
            $data = Input::json(file_get_contents('php://input'));

            $email = (string) $data['email'];
            $password = (string) $data['password'];
            $salt = Hash::getSalt($email);
            if (!$salt) {
                throw new Exception('Нет соли');
            }

            $hashes = Hash::passwordHash($password, $salt);

            $userId = AuthModel::checkEmailAndPassword($email, $hashes['hash']);
            if (!$userId) {
                throw new Exception('Пользователь не найден');
            }
	        AuthModel::setAuthCookie($userId);
            $this->toJSON([
                'errors' => [],
                'result' => (bool) $userId,
            ], true);
        } catch (Exception $exception) {
            $this->toJSON([
                'errors' => $exception->getMessage(),
                'result' => false,
            ], true);
        }
	}
}
