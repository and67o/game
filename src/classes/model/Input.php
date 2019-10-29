<?php


namespace Router\Models;


class Input
{
	/**
	 * Какой метод запроса
	 * @param string $type
	 * @return bool
	 */
	public static function isPostMethod($type = 'post')
	{
		switch ($type) {
			case 'post':
				return (bool) $_POST;
				break;
			case 'get':
				return !$_GET ? true : false;
				break;
			default:
				return false;
				break;
		}
	}
	
	/**
	 * Получить значение
	 * @param $item
	 * @return string
	 */
	public static function get($item)
	{
		if (!$item) {
			return '';
		}
		
		if (isset($_POST[$item])) {
			return $_POST[$item];
		} else if (isset($_GET[$item])) {
			return $_GET[$item];
		}
	}
}
