<?php


namespace Router\src\classes\model;


use PHPUnit\Runner\Exception;
use Router\Models\Model;
use Router\Models\Services\Session;

class Game extends Model
{
	
	protected $computerNumber;
	protected $maxCountNumber;
	
	const GAME_NEW = 0;
	
	public function __construct($computerNumber = 0)
	{
		if ($computerNumber) {
		    $this->setActualNumber($computerNumber);
			$this->maxCountNumber = 4;
		}
	}
	
	public function getActualNumber()
	{
		return $this->computerNumber;
	}
	
	public function setActualNumber($computerNumber)
	{
		$this->computerNumber = $computerNumber;
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
		$computerNumbers = str_split($this->getActualNumber());
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
	public function createGame()
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
		return $res ? : 0;
	}
	
	/**
	 * @param $userId
	 * @return int
	 */
	public function createFullGame($userId)
	{
		try {
			$gameId = $this->createGame();

			if (!$gameId) {
				throw new Exception('Game not created');
			}

			if (GameNumbers::writeNumber($gameId, $userId)) {
				$Session = new Session();
				$Session->start();
				$Session->set('gameId', $gameId);
			} else {
				throw new Exception('Not create number of game');
			}

		} catch (Exception $message) {
			exit;
		}
		return $gameId;
		
		
	}
}
