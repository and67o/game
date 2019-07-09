<?php


namespace Router\src\classes\model;


use Router\Db;

class Model
{
	/**
	 * Возвращает объект DB для работы с БД по умолчанию.
	 * @return DB
	 */
	protected static function _db() {
		return Db::getInstance();
	}
}