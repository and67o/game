<?php


namespace Router\src\classes\controller;

use Router\Models\Input;
use Router\Models\Session;
use Router\src\classes\interfaces\BaseFacade;
use \Router\src\classes\model\Game;

/**
 * Класс отвечающий за игру
 * Class GameField
 */
class GameField extends CommonController implements BaseFacade
{
	/** @var int уникальный идентификатор игры */
	public $gameId;
	
	public function __construct($param = '')
	{
		if ($param) {
			session_start();
			$_SESSION['gameId'] = $param;
		}
		$this->gameId = $param;
	}
	
	/**
	 * Главнаяс страница игры
	 */
	public function index()
	{
		$permanentValues = $this->getBaseParam('Игра номер ' . $this->gameId);
		$paramsForPage = [
			'moves' => Game::GetAllInformByGame($this->gameId) ? : []
		];
		$this->render('GameField/GameField',
			array_merge(
				$permanentValues,
				$paramsForPage
			)
		);
	}
	
	/**
	 * Ajax Метод добавления нового числа
	 */
	public function addNewNumber()
	{
		$this->locationRedirect('/', !$this->isAjax());
		$newNumber = Input::get('number');
		session_start();
		$gameId = Session::exists('gameId') ? (int) Session::get('gameId') : '';
		$rightPosition = [];
		if ($gameId) {
			$number = Game::getGameNumberByGameId($gameId);
			$Game = new Game($number);
			$rightPosition = $Game->checkNumber($newNumber);
			
			$Game->saveMove([
				'g_id' => $gameId,
				'right_position' => $rightPosition['rightPosition'],
				'right_count' => $rightPosition['rightCount'],
				'move' => $newNumber
			]);
		}
		$this->toJSON($rightPosition, true);
	}
}
