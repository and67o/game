<?php


namespace Router\Models\Services;

use Router\Models\Model;

/**
 * Class Hash
 * @package Router\Models\Services
 */
class Hash extends Model
{
	
	const MAX_COUNT_OF_ITERATION = 10;
	
	/**
	 * @param $password
	 * @param string $salt
	 * @return string
	 */
	public static function makeHash(string $password, string $salt = '') : string
	{
		return md5(md5($password . md5($salt)));
	}
	
	/**
	 * @param string $password
	 * @param string $salt
	 * @param int $iterations
	 * @return array
	 */
	public static function passwordHash(
		string $password,
		string $salt = '',
		int $iterations = self::MAX_COUNT_OF_ITERATION
	) : array
	{
		$salt || $salt = self::makeSalt();
		$hash = self::makeHash($password, $salt);
		for ($i = 0; $i < $iterations; ++$i) {
			$hash = md5(md5($hash));
		}
		return [
			'hash' => $hash,
			'salt' => $salt
		];
	}
	
	/**
	 * Генерирует соль
	 * @return string
	 */
	public static function makeSalt()
	{
		return uniqid();
	}
	
	/**
	 * @param string $email
	 * @return array
	 */
	public static function getPasswordParam(string $email)
	{
		return self::_db()
			->select(['salt', 'password'])
			->table('users')
			->where('email = ?')
			->get([$email])
			->first();
	}
}
