<?php


namespace Router\src\classes\model;


class Game extends Model
{

	protected $computerNumber;
	protected $maxCountNumber;

	const GAME_IS_RUNNING = 0;
	
	public function __construct($computerNumber)
	{
		$this->computerNumber = $computerNumber;
		$this->maxCountNumber = 4;
	}
	
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
			'rightCount' => $rightCount
		];
	}
	
	/**
	 * создание новой игры
	 * @return bool
	 */
	public static function createGame()
	{
		$createGame = self::_db()->query(
			'insert into games
					(dt_start, dt_finish, game_status)
				values (\'1970-01-01\', \'1970-01-01\', 0)
		');
		return $createGame ? mysqli_insert_id(self::_db()) : 0;
	}
	
	public function isNumberUsedInThisGame(int $gameId, int $number) {
		$sql = sprintf('
			SELECT 1
			FROM game_process
			WHERE g_id = %d
			  AND move = %d
			', $gameId, $number
		);
		if (Model::_db()) {
			return Model::_db()->fetchFirstField($sql);
		}
//		return Model::_db()->fetchFirstField($sql);
		return 222;
	}
	
	/**
	 * Записывает загаднное число
	 * @param int $gameId - уникальный идентификатор игры
	 * @param int $userId - уникальный идентификатор пользователя
	 * @return bool
	 */
	public static function writeNumber(int $gameId, int $userId = 0): bool
	{
		$number = self::createNumber();
		$sql = sprintf('
			insert into game_numbers
				(g_id, user_id, game_number)
			VALUES (%d, %d, %d)
		', $gameId, $userId, $number);
		return Model::_db()->query($sql);
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
	public static function qgetGameNumberByGameId(int $gameId) : int
	{
		if (!$gameId) {
			return 0;
		}
		$sql = sprintf('SELECT game_number FROM game_numbers WHERE g_id = %d', $gameId);
//		var_dump(Model::_db()->rff() ?: 0);exit;
		return Model::_db()->fetchFirstField($sql) ?: 0;
	}
	
	public static function getGameNumberByGameId(int $gameId) {
		$sql = sprintf('
			SELECT game_number FROM game_numbers WHERE g_id = %d
			', $gameId
		);
		return Model::_db()->fetchFirstField($sql);
	}
	
	
	
	/**`
	 * сохранить информацию о ходе
	 * @param int $gameId
	 * @param array $rightPosition
	 * @param int $number
	 * @return bool
	 */
	public function saveMove(int $gameId, array $rightPosition, int $number) : bool {
		$sql = sprintf(
	'INSERT INTO game_process (g_id, dt, right_count, right_position, move)
			VALUES (%d, "%s", %s, %s, %s)',
			$gameId, date('Y-m-d H:i:s'), $rightPosition['rightCount'],
			$rightPosition['rightPosition'], $number
		);
		return Model::_db()->query($sql);
	}
	
	/**
	 * Получить все ходы по одно игре
	 * @param int $gameId
	 * @return array
	 */
	public static function GetAllInformByGame(int $gameId) : array {
		$sql = sprintf(
			'SELECT right_count, right_position, move FROM game_process WHERE g_id = %d
		', $gameId);
		return self::_db()->fetchAll($sql);
	}
	
	/**
	 * Получить все игры пользователя
	 * @param int $userId
	 * @return array
	 */
	public static function getAllGamesByUserId(int $userId) :array {
		$sql = sprintf(
			'SELECT g_id FROM game_numbers WHERE user_id = %d
		', $userId);
		return self::_db()->fetchAll($sql);
	}
	
}
