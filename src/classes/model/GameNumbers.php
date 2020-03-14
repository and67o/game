<?php


namespace Router\Models;


use PDOException;
use Router\Db;

/**
 * Class GameNumbers
 * @package Router\Models
 */
class GameNumbers extends Model
{
	/**
	 * Записывает загаданное число
	 * @param int $gameId - уникальный идентификатор игры
	 * @param int $userId - уникальный идентификатор пользователя
	 * @return string
	 */
	public static function writeNumber(int $gameId, int $userId = 0)
	{
		$res = self::_db()
			->table('game_numbers')
			->add([
				'g_id' => $gameId,
				'user_id' => $userId,
				'game_number' => self::createNumber()
			]);
		if (!$res) {
			throw new PDOException('There was a problem creating this account.');
		}
		return $res;
	}
	
	/**
	 * Формирует случайное число компьютера
     * @phpunit
     * @return int
	 */
	public static function createNumber()
	{
		static $numbers = [];
		$number = rand(0, 9);
		if (count($numbers) != 4 && !in_array($number, $numbers)) {
			array_push($numbers, $number);
		}
		if (count($numbers) != 4) {
			self::createNumber();
		}
		return implode('', $numbers);
	}
	
	/**
	 * Получить число игры по уникальному идентификатору игры
	 * @param int $gameId
	 * @return int
	 */
	public static function getGameNumberByGameId(int $gameId)
	{
		return self::_db()
			->select(['game_number'])
			->table('game_numbers')
			->where('g_id = ?')
			->get([$gameId])
			->single();
	}
	
	/**
	 * Получить все игры пользователя
	 * @param int $userId
	 * @return Db
	 */
	public static function getAllGamesByUserId(int $userId) : Db
	{
		return self::_db()
			->select(['g_id'])
			->table('game_numbers')
			->where('user_id = ?')
			->get([$userId]);
	}
}
