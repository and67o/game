<?php


namespace Router\src\classes\model;


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
	 * @param $number
	 * @return array
	 */
	public function checkNumber($number)
	{
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
	 * @return bool
	 */
	public static function createGame()
	{
		$res = !self::_db()
			->table('games')
			->add([
				'dt_start' => '1970-01-01',
				'dt_finish' => '1970-01-01',
				'game_status' => self::GAME_NEW,
			])
			->getLastId();
		if (!$res) {
			throw new \PDOException('There was a problem creating this account.');
		}
		return $res ? : 0;
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
	 * @return bool
	 */
	public static function writeNumber(int $gameId, int $userId = 0) : bool
	{
		$res = !self::_db()
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
		static $arr = [];
		$number = rand(0, 9);
		if (count($arr) != 4 && !in_array($number, $arr)) {
			array_push($arr, $number);
		}
		if (count($arr) != 4) {
			self::createNumber();
		}
		return implode('', $arr);
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
			->get([$gameId]);
	}
	
	/**`
	 * сохранить информацию о ходе
	 * @param array $moveParam
	 * @return bool
	 */
	public function saveMove(array $moveParam) : bool
	{
		$res = !self::_db()
			->table('game_process')
			->add($moveParam);
		if (!$res) {
			throw new \PDOException('There was a problem creating this account.');
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
