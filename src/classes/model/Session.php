<?php


namespace Router\Models;


use Router\src\classes\interfaces\CrudEssence;

class Session extends CrudEssence
{
	public function start() {
		session_start();
	}

	public function set($name, $value)
	{
		return $_SESSION[$name] = $value;
	}

}
