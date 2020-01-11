<?php


namespace Router\src\classes\model;


use Router\src\classes\model\services\Cookie;

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
	 * @param int $userId
	 */
	public static function setAuthCookie(int $userId)
	{
		Cookie::set('userId', $userId, strtotime('+30 days'));
	}
	
}
