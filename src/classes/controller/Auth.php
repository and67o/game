<?php


namespace Router\src\classes\controller;

use PHPUnit\Runner\Exception;
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

            $userId = model\Auth::checkEmailAndPassword($email, $hashes['hash']);
            if (!$userId) {
                throw new Exception('Пользователь не найден');
            }
            model\Auth::setAuthCookie($userId);
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
