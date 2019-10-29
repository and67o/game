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
		$this->locationRedirect('/', !$this->isAjax());
		
		if (!Input::isPostMethod()) {
			exit;
		}
//		$errors = $this->_validateParam();
//		var_dump($errors);exit;
//		if ($errors['password'] || $errors['email']) {
//			exit;
//		}
		$User = new User();
		$salt = Hash::salt(Hash::SALT_LENGTH);
		try {
			$User->create([
				'email' => Input::get('email'),
				'password' => Hash::make(Input::get('password'), $salt),
				'salt' => $salt,
				'name' => 'oleg',
//				'name' => Input::get('name') ,
				'reg_dt' => date('Y-m-d H:i:s'),
				'role_id' => Role::USER_ROLE,
			]);
			Session::flash('home', 'You have been registered and can now log in!');
			header('Location: /');
		} catch (Exception $e) {
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
