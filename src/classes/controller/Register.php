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
            $this->Input->setInputParam(
                file_get_contents('php://input'),
                Input::METHOD_REQUEST_POST
            );
		    
			if (!$this->Input->checkRequestMethod()) throw new Exception('не тот метод');
			
			$errors = $this->_validateParam();
			//TODO errors или error вывод одной ошибки или всех
			if ($errors) throw new Exception(array_shift($errors));
			
			$userId = $this->createUser();
			if (!$userId) throw new \PDOException('Проблемы с регистрацией');
			Auth::setAuthCookie('userId', $userId);

			//TODO Один ответ
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
     * Создать пользователя
     * @return int
     */
    private function createUser()
    {
        $hashes = Hash::passwordHash($this->Input->get('password', 'string'));

        return (int) $this->User->create([
            'email' => $this->Input->get('email', 'string'),
            'password' => $hashes['hash'],
            'salt' => $hashes['salt'],
            'name' => $this->Input->get('name', 'string'),
            'reg_dt' => date('Y-m-d H:i:s'),
            'role_id' => Role::USER_ROLE,
        ]) ?? 0;
	}
	
	/**
	 * Валидация данных
	 * @param $data
	 * @return bool|mixed
	 */
	private function _validateParam()
	{
		$this->_baseValidate($this->Input->get('email', 'string'), 'email')->isExist()->isValidateEmail();
		$this->_baseValidate($this->Input->get('password', 'string'), 'password');
		$this->_baseValidate($this->Input->get('name', 'string'), 'name');

		return $this->Validation->isSuccess()
            ? false
            : $this->Validation->getErrors();
	}
	
	/**
	 * @param $data
	 * @param $nameField
	 * @return Validation
	 */
	private function _baseValidate($data, $nameField)
	{
		return $this->Validation
			->setName($nameField)
			->setValue($data)
			->required()
			->min()
			->max();
	}
}
