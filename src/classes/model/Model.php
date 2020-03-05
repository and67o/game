<?php

namespace Router\Models;

use Router\Db;

class Model
{
	/**
	 * Возвращает объект DB для работы с БД по умолчанию.
	 * @return DB
	 */
	protected static function _db()
	{
		return Db::getInstance();
	}
    
    /**
     * Возвращает текущее время для БД
     * @return string
     * @throws \Exception
     */
    public static function now()
    {
        return (new \DateTime('now'))->format('Y-m-d H:i:s');
    }
}
