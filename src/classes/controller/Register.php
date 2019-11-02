<?php


namespace Router\src\classes\controller;


use PHPUnit\Runner\Exception;
use Router\Models\Hash;
use Router\Models\Input;
use Router\Models\Role;
use Router\Models\Session;
use Router\Models\User;
use Router\src\classes\model\Validation;

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
			exit;
		}
//		$errors = $this->_validateParam();
//		var_dump($errors);exit;
//		if ($errors['password'] || $errors['email']) {
//			exit;
//		}
		$data = Input::json(file_get_contents('php://input'));
		$User = new User();
		$salt = Hash::salt(Hash::SALT_LENGTH);
		try {
			$userId = (int) $User->create([
				'email' => $data['email'],
				'password' => Hash::make($data['password'], $salt),
				'salt' => $salt,
				'name' => $data['name'],
				'reg_dt' => date('Y-m-d H:i:s'),
				'role_id' => Role::USER_ROLE,
			]);
			$this->setAuthCookie($userId);
			$this->toJSON([
				'result' => (bool) $userId,
			], true);
		} catch (\PDOException $e) {
			var_dump($e->getMessage());
			exit;
		}
	}
	
	/**
	 * Валидация данных
	 */
	private function _validateParam()
	{
		$errors = [];
		$errors['email'] = Validation::email(Input::get('email')) ? : [];
		$errors['password'] = Validation::password(Input::get('password')) ? : [];
		return $errors;
	}
}
