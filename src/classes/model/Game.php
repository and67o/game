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
	 * создание ноеой игры
	 * @return bool
	 */
	public static function createGame()
	{
		return Model::_db()->query('insert into games (dt_start, dt_finish, game_status) values (\'1970-01-01\', \'1970-01-01\', 0)');

	}


	public static function validateStringField($postParam, $nameField)
	{
		$error = '';
		if (!$postParam) {
			return [];
		}
		if (Validation::minLength($postParam, 3)) {
			$error = sprintf('Минимальная длина поля %s  - %d символа', $nameField, Validation::MIN_LENGTH_OF_FIELD);
		}
		return $error;
	}
}