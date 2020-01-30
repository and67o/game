<?php


namespace Router\src\classes\controller;

use Router\src\classes\interfaces\BaseTwigController;
use \Router\src\classes\model\Game;
use Router\src\classes\model\GameNumbers;
use Router\src\classes\model\GameProcess;
use Router\src\classes\model\Input;
use Router\src\classes\model\services\Session;

/**
 * Класс отвечающий за игру
 * Class GameField
 */
class GameField extends BaseTwigController
{
	/** @var int уникальный идентификатор игры */
	public $gameId;
	protected $tplName = '/GameField/GameField';
	protected $pageTitle = 'Игра номер';
	
	public function __construct($gameId = '')
	{
		if ($gameId) {
			$Session = new Session();
			$Session->start();
			$Session->set('gameId', $gameId);
		}
		$this->gameId = $gameId;
		$this->pageTitle = 'Игра номер ' . $this->gameId;
		parent::__construct();
	}
	
	/**
	 * Главная страница игры
	 */
	public function index()
	{
		$this->render([
			'moves' => GameProcess::getAllInformByGame($this->gameId) ?: []
		]);
	}
	
	/**
	 * Метод добавления нового числа
	 */
	public function addNewNumber()
	{
		$data = Input::json(file_get_contents('php://input'));
		$newNumber = (int) $data['number'];

		$Session = new Session();
		$Session->start();
		
		$gameId = $Session->exists('gameId') ? (int) $Session->get('gameId') : '';
		
		$rightPosition = [];
		if ($gameId) {
			$number = GameNumbers::getGameNumberByGameId($gameId);
			$rightPosition = (new Game($number))->checkNumber($newNumber);
			GameProcess::saveMove([
				'g_id' => $gameId,
				'dt' => date('Y-m-d H:i:s'),
				'right_position' => $rightPosition['rightPosition'],
				'right_count' => $rightPosition['rightCount'],
				'move' => $newNumber
			]);
		}
		$this->toJSON($rightPosition, true);
	}
}
