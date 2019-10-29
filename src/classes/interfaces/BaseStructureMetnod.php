<?php


namespace Router\src\classes\interfaces;


interface BaseStructureMethod
{
	public static function exists($name);
	
	public static function get($name);
	
//	public static function put($name, $value, $expiry);
	
	public static function delete($name);
}
