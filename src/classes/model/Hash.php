<?php


namespace Router\Models;


use Router\src\classes\model\Model;

class Hash extends Model
{
	
	const SALT_LENGTH = 32;
	const MAX_COUNT_OF_ITERATION = 10;

	/**
	 * @param $password
	 * @param string $salt
	 * @return string
	 */
	public static function make($password, $salt = '') {
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
	 * @param $email
	 * @return mixed
	 */
	public static function getSalt($email) {
		 $res = self::_db()
			->select(['salt'])
			->table('users')
			->where('email = ?')
			->get([$email]);
		return array_shift($res)->salt;
	}
}
