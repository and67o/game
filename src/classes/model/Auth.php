<?php


namespace Router\src\classes\model;


class Auth extends Model
{
	/**
	 * проверяет наличие пользователя по email и пароль
	 * @param string $email
	 * @param string $password
	 * @return bool
	 */
	public function checkEmailAndPassword(string $email, string $password)
	{
		return self::_db()->fetchFirstField(
			$this->select(['u_id'])
				->from('users', 'u')
				->where('password = ? AND email = ?')
				->__toString(),
			[
				$password,
				$email
			]
		);
	}
	
	
}
