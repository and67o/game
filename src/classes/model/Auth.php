<?php


namespace Router\src\classes\model;


class Auth extends Model
{
	/**
	 * Проверка на существование email
	 * @param string $email
	 * @return bool
	 */
	public static function isEmailExist(string $email) : bool
	{
		if (!$email) {
			return false;
		}
		$sql = sprintf('SELECT 1 FROM users WHERE email = "%s"', $email);
		return (bool) self::_db()->fetchFirstField($sql);
	}
	
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
