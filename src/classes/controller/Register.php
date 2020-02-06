<?php

namespace Router\Controller;

use Router\Model\Auth;
use Router\Model\Role;
use Router\Model\User;
use Router\Models\Services\Hash;
use Router\Models\Services\Input;

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
		if (!Input::isPostMethod()) {
			$this->toJSON([
				'errors' => 'Ошибка',
				'result' => false
			], true);
		}
		$data = Input::json(file_get_contents('php://input'));
		$errors = $this->_validateParam($data);
		$password = (string) $data['password'];
		$hashes = Hash::passwordHash($password);
		if ($errors) {
			$this->toJSON([
				'errors' => $errors,
				'result' => false
			], true);
		}
		$data = Input::json(file_get_contents('php://input'));
		$User = new User();
		try {
			$userId = (int) $User->create([
				'email' => $data['email'],
				'password' => $hashes['hash'],
				'salt' => $hashes['salt'],
				'name' => $data['name'],
				'reg_dt' => date('Y-m-d H:i:s'),
				'role_id' => Role::USER_ROLE,
			]);
			Auth::setAuthCookie($userId);
			$this->toJSON([
				'result' => (bool) $userId,
			], true);
		} catch (\PDOException $e) {
			echo $e->getMessage();
			exit;
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
