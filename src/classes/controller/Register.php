<?php

namespace Router\Controller;

use Exception;
use Router\Models\Auth;
use Router\Models\Role;
use Router\Models\User;
use Router\Models\Services\Hash;
use Router\Models\Services\Input;
use Router\Models\Validation;

/**
 * Класс отвечающий за регистрацию
 * Class Register
 */
class Register extends CommonController
{
	/**
	 * Регистрация пользователя
	 */
	public function register()
	{
        try {
            if (!Input::isPostMethod()) throw new Exception('не тот метод');
    
            $data = Input::json(file_get_contents('php://input'));

            $errors = $this->_validateParam($data);
            if ($errors) throw new Exception($errors);
    
            $hashes = Hash::passwordHash((string) $data['password']);

            $User = new User();
            $userId = (int) $User->create([
                'email' => $data['email'],
                'password' => $hashes['hash'],
                'salt' => $hashes['salt'],
                'name' => $data['name'],
                'reg_dt' => date('Y-m-d H:i:s'),
                'role_id' => Role::USER_ROLE,
            ]);
            if (!$userId) throw new \PDOException('Проблемы с регистрацией');
            Auth::setAuthCookie($userId);

            $this->toJSON([
                'result' => (bool) $userId,
            ], true);

        } catch (\PDOException $e) {
            echo $e->getMessage();
            exit;
        } catch (Exception $exception) {
            $this->toJSON([
                'errors' => $exception->getMessage(),
                'result' => false
            ], true);
        }
	}
	
	/**
	 * Валидация данных
	 * @param $data
	 * @return bool|mixed
	 */
	private function _validateParam($data)
	{
		$Validation = new Validation();
		$this->_baseValidate($data['email'], 'email')->isExist()->isValidateEmail();
		$this->_baseValidate($data['password'], 'password');
		$this->_baseValidate($data['name'], 'name');
		return $Validation->isSuccess() ? false : $Validation->getErrors();
	}
    
    /**
     * @param $data
     * @param $nameField
     * @return Validation
     */
	private function _baseValidate($data, $nameField)
	{
		$Validation = new Validation();
		return $Validation
			->setName($nameField)
			->setValue($data)
			->required()
			->min()
			->max();
	}
}
