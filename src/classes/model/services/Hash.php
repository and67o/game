<?php


namespace Router\Models\Services;

use Router\Models\Model;

class Hash extends Model
{
	
	const MAX_COUNT_OF_ITERATION = 10;
	
	/**
	 * @param $password
	 * @param string $salt
	 * @return string
	 */
	public static function make($password, $salt = '')
	{
		return md5(md5($password . md5(sha1($salt))));
	}
	
	/**
	 * @param $password
	 * @param null $salt
	 * @param int $iterations
	 * @return array
	 */
	public static function passwordHash($password, $salt = null, $iterations = self::MAX_COUNT_OF_ITERATION)
	{
		$salt || $salt = uniqid();
		$hash = self::make($password, $salt);
		for ($i = 0; $i < $iterations; ++$i) {
			$hash = md5(md5(sha1($hash)));
		}
		return [
			'hash' => $hash,
			'salt' => $salt
		];
	}
	
	/**
	 * @param string $email
	 * @return string
	 */
	public static function getSalt(string $email)
	{
		return self::_db()
			->select(['salt'])
			->table('users')
			->where('email = ?')
			->get([$email])
			->single();
	}
}
