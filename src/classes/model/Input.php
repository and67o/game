<?php


namespace Router\Models\Services;


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
				return $_SERVER['REQUEST_METHOD'] == 'POST';
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
	 * Метод преобразования строки json в массив
     * @phpunit
     * @param string $jsonString
	 * @return array
	 */
	public static function json($jsonString)
	{
		// Если там массив, то обработка не требуется
		return is_array($jsonString)
			? $jsonString
			: json_decode($jsonString, JSON_OBJECT_AS_ARRAY);
	}
}
