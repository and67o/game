<?php


namespace Router\Models;

/**
 * Class GameProcess
 * @package Router\Models
 */
class GameProcess extends Model
{
	
	/**
	 * сохранить информацию о ходе
	 * @param array $moveParam
	 * @return string
	 */
	public static function saveMove(array $moveParam)
	{
		$res = self::_db()
			->table('game_process')
			->add($moveParam);
		if (!$res) {
			throw new \PDOException('Ход не сохранен');
		}
		return $res;
	}
	
	/**
	 * Получить все ходы по одной игре
	 * @param int $gameId
	 * @return array
	 */
	public static function getAllInformByGame(int $gameId) : array
	{
		return self::_db()
			->select([
				'right_count',
				'right_position',
				'move'
			])
			->table('game_process')
			->where('g_id = ?')
			->get([$gameId])
			->getResult();
	}
	
	/**
	 * Использовалось ли число в игре
	 * @param int $gameId
	 * @param int $number
	 * @return mixed
	 */
	public function isNumberUsedInThisGame(int $gameId, int $number)
	{
		return self::_db()
			->select([1])
			->table('game_process')
			->where('g_id = ? AND move = ?')
			->get([
				$gameId,
				$number
			])
			->getResult();
	}
	
}
