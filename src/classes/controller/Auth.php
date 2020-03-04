<?php


namespace Router\Controller;

use Exception;
use Router\Models\Services\Hash;
use Router\Models\Services\Input;
use Router\Models\Auth as AuthModel;
use Router\Models\Services\Session;


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
            $Input = new Input(
                file_get_contents('php://input'),
                Input::METHOD_REQUEST_POST
            );
            
            if (!$Input->checkRequestMethod()) throw new Exception('не тот метод');
    
            $email = $Input->get('email', 'string');
            $password = $Input->get('password', 'string');
            $salt = Hash::getSalt($email);
            if (!$salt) {
                throw new Exception('Ошибка авторизации');
            }

            $hashes = Hash::passwordHash($password, $salt);
            
            if ($password !== $hashes['hash']) {
	            throw new Exception('Пользователь не найден');
            }

            $userId = AuthModel::checkEmailAndPassword($email, $hashes['hash']);
            if (!$userId) {
                throw new Exception('Пользователь не найден');
            }
	        Session::set('user', $userId);
	        AuthModel::setAuthCookie('userId', $userId);
	        AuthModel::setAuthCookie('hash', $hashes['salt']);
	
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
