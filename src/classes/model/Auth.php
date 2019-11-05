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
		 $res = self::_db()
			->select(['u_id'])
			->table('users')
			->where('password = ? AND email = ?')
			->get([
				$password,
				$email
			]);
		return array_shift($res)->u_id;
	}
	
	
}
