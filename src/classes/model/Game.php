<?php


namespace Router\src\classes\model;


use Router\Db;

class Game extends Model
{
	
	protected $computerNumber;
	protected $maxCountNumber;
	
	const GAME_NEW = 0;
	
	public function __construct($computerNumber)
	{
		$this->computerNumber = $computerNumber;
		$this->maxCountNumber = 4;
	}
	
	/**
	 * Возвращает результат проверки числа
	 * @param int $number
	 * @return array
	 */
	public function checkNumber(int $number)
	{
		if (!$number) {
			return [
				'youWin' => false
			];
		}

		$rightCount = 0;
		$rightPosition = 0;
		$computerNumbers = str_split($this->computerNumber);
		$myNumbers = str_split($number);

		foreach ($myNumbers as $position => $myNumber) {
			$isNumberHave = in_array($myNumber, $computerNumbers);
			if ($isNumberHave) {
				$rightCount++;
				if ($myNumber == $computerNumbers[$position]) {
					$rightPosition++;
				}
			}
		}

		return [
			'rightPosition' => $rightPosition,
			'rightCount' => $rightCount,
			'youWin' => $rightPosition + $rightCount == $this->maxCountNumber * 2
		];
	}

	/**
	 * создание новой игры
	 * @return int
	 */
	public static function createGame()
	{
		$res = self::_db()
			->table('games')
			->add([
				'dt_start' => date('Y-m-d H:i:s'),
				'game_status' => self::GAME_NEW,
			]);
		if (!$res) {
			throw new \PDOException('There was a problem creating this account.');
		}
		return $res ?: 0;
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
			]);
	}
	
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
	
	/**`
	 * сохранить информацию о ходе
	 * @param array $moveParam
	 * @return Db
	 */
	public function saveMove(array $moveParam)
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
	 * Получить все ходы по одно игре
	 * @param int $gameId
	 * @return array
	 */
	public static function GetAllInformByGame(int $gameId) : array
	{
		return self::_db()
			->select([
				'right_count',
				'right_position',
				'move'
			])
			->table('game_process')
			->where('g_id = ?')
			->get([$gameId]);
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
