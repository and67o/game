<?php


namespace Router\src\classes\model;


use Router\Db;

class GameNumbers extends Model
{
	/**
	 * Записывает загаданное число
	 * @param int $gameId - уникальный идентификатор игры
	 * @param int $userId - уникальный идентификатор пользователя
	 * @return Db
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
			throw new \PDOException('There was a problem creating this account.');
		}
		return $res;
	}
	
	/**
	 * возвращет случайное число компьютера
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
		$res = self::_db()
			->select(['game_number'])
			->table('game_numbers')
			->where('g_id = ?')
			->get([$gameId]);
		return array_shift($res)->game_number;
	}
	
	/**
	 * Получить все игры пользователя
	 * @param int $userId
	 * @return array
	 */
	public static function getAllGamesByUserId(int $userId) : array
	{
		return self::_db()
			->select(['g_id'])
			->table('game_numbers')
			->where('user_id = ?')
			->get([$userId]);
	}
}
