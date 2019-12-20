<?php


namespace Router\Models;


class Session
{
	/**
	 *
	 */
	public function start()
	{
		session_start();
	}
	
	/**
	 * @param $name
	 * @param $value
	 * @return mixed
	 */
	public function set($name, $value)
	{
		return $this->essence[$name] = $value;
	}
	
	/**
	 * @param $name
	 * @return bool
	 */
	public function exists($name)
	{
		return isset($_SESSION[$name]);
	}
	
	/**
	 * @param $name
	 * @return mixed
	 */
	public function get($name)
	{
		return $_SESSION[$name];
	}
	
	/**
	 * @param $name
	 */
	public function delete($name)
	{
		if ($this->exists($name)) {
			unset($_SESSION[$name]);
		}
	}
	
}
