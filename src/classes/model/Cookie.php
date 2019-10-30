<?php


namespace Router\Models;


use Router\src\classes\interfaces\BaseStructureMethod;

class Cookie implements BaseStructureMethod
{
	public static function exists($name) {
		return isset($_COOKIE[$name]);
	}
	
	public static function get($name) {
		return $_COOKIE[$name];
	}
	
	public static function put($name, $value, $expiry, $path = '/') {
		if(setcookie($name, $value, time() + $expiry, $path)) {
			return true;
		}
		return false;
	}
	
	public static function delete($name) {
		self::put($name, '', time() -1);
	}
	
}
