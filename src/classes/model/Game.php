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
		$db = Model::_db();
		$createGame = $db->query(
			'insert into games
					(dt_start, dt_finish, game_status)
				values (\'1970-01-01\', \'1970-01-01\', 0)
		');
		return $createGame ? $db->getLastId() : 0;
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
		return rand(1000, 9999);
	}
	
}
