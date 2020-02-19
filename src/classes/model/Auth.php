<?php


namespace Router\Models;

use Router\Models\Services\Cookie;

class Auth extends Model
{
	/**
	 * проверяет наличие пользователя по email и пароль
	 * @param string $email
	 * @param string $password
	 * @return bool
	 */
	public static function checkEmailAndPassword(string $email, string $password)
	{
	    //TODO перенести в Users
		return self::_db()
			->select(['u_id'])
			->table('users')
			->where('password = ? AND email = ?')
			->get([
				$password,
				$email
			])
			->single();
	}
	
	/**
	 * Задает авторизационные куки
	 * @param $name
	 * @param $value
	 */
	public static function setAuthCookie($name, $value)
	{
		Cookie::set($name, $value, strtotime('+30 days'));
	}
	
}
