<?php


namespace Router\Models;


/**
 * Class Images
 * @package Router\Models
 */
class Images extends Model
{
	const TABLE_NAME = 'images';

	/**
	 * @param array $imgPath
	 * @return int
	 */
	public static function saveImg(array $imgPath): int
	{
		return (int)self::_db()
			->table(self::TABLE_NAME)
			->add($imgPath) ?? 0;
	}
}