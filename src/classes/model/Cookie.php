<?php


namespace Router\Models;


use Router\src\classes\interfaces\CrudEssence;

class Cookie extends CrudEssence
{

	public static function set($name, $value, $expiry, $path = '/')
	{
		if (setcookie($name, $value, time() + $expiry, $path)) {
			return true;
		}
		return false;
	}

}
