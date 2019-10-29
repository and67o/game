<?php


namespace Router\Models;


class Token
{
	const TOKEN_NAME = 'token';
	
	public static function generate()
	{
		return Session::put(self::TOKEN_NAME, md5(uniqid()));
	}
	
	public static function check($token)
	{
		$tokenName = self::TOKEN_NAME;
		
		if (Session::exists($tokenName) && $token === Session::get($tokenName)) {
			Session::delete($tokenName);
			return true;
		}
		
		return false;
	}
}
