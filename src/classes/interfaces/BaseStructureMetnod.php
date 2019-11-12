<?php


namespace Router\src\classes\interfaces;


interface BaseStructureMethod
{
    /**
     * проверка на существоание
     * @param $name
     * @return bool
     */
//	public static function exists($name);
	
//	public static function get($name);
	
//	public static function put($name, $value, $expiry);
	
	public static function delete($name);
}
