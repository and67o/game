<?php


namespace Router\Models;


class Hash
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
}
