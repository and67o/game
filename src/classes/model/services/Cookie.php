<?php


namespace Router\src\classes\model\services;


class Cookie
{
	/**
	 * @param $name
	 * @param $value
	 * @param $expiry
	 * @param string $path
	 * @return bool
	 */
	public static function set($name, $value, $expiry, $path = '/')
	{
		if (setcookie($name, $value, time() + $expiry, $path)) {
			return true;
		}
		return false;
	}
	
	/**
	 * @param $name
	 * @return bool
	 */
	public function exists($name)
	{
		return isset($_COOKIE[$name]);
	}
	
	/**
	 * @param $name
	 * @return mixed
	 */
	public function get($name)
	{
		return $_COOKIE[$name];
	}
	
	/**
	 * @param $name
	 */
	public function delete($name)
	{
		if ($this->exists($name)) {
			unset($_COOKIE[$name]);
		}
	}
	
	
}
