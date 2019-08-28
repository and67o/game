<?php


namespace Router\src\classes\controller;

use Router\src\classes\interfaces\BaseFacade;
use \Router\src\classes\model\Game;

/**
 * Класс отвечающий за игру
 * Class GameField
 */
class GameField extends CommonController implements BaseFacade
{
	/** @var int уникальный идентификатор игры*/
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
		$permanentValues = $this->headerParams('Игра номер ' . $this->gameId);
		$paramsForPage = [
			'moves' => Game::GetAllInformByGame($this->gameId) ?: []
		];
		$this->render('GameField', array_merge($permanentValues, $paramsForPage));
	}
	
	/**
	 * Ajax Метод добавления нового числа
	 */
	public function addNewNumber() {
		$this->locationRedirect('/', !$this->isAjax());
		$newNumber = (int) $_POST['number'];
		session_start();
		$gameId = isset($_SESSION['gameId']) ? (int) $_SESSION['gameId'] : '';
		$rightPosition = [];
		if ($gameId) {
			$number = Game::getGameNumberByGameId($gameId);
			$Game = new Game($number);
			$rightPosition = $Game->checkNumber($newNumber, $gameId);
			$Game->saveMove($gameId, $rightPosition, $newNumber);
		}
		$this->toJSON($rightPosition, true);
	}
}
