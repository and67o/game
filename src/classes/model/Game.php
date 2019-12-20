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
	
}
