<?php


namespace Router\Models;


use Router\src\classes\model\Model;

class Hash extends Model
{
	
	const SALT_LENGTH = 32;
	
	public static function make($string, $salt = '') {
		return hash('sha256', $string . $salt);
	}
	
	public static function salt($length) {
		return random_bytes($length);
	}
	
	public static function unique() {
		return self::make(uniqid());
	}
	
	public static function passwordHash($password, $salt = null, $iterations = 10)
	{
		$salt || $salt = uniqid();
		$hash = md5(md5($password . md5(sha1($salt))));
		for ($i = 0; $i < $iterations; ++$i) {
			$hash = md5(md5(sha1($hash)));
		}
		return [
			'hash' => $hash,
			'salt' => $salt
		];
	}
	
	public static function getSalt($email) {
		 $res = self::_db()
			->select(['salt'])
			->table('users')
			->where('email = ?')
			->get([$email]);
		return array_shift($res)->salt;
	}
}
