<?php


namespace Router\src\classes\controller;

use Router\Models\Input;
use Router\Models\Session;
use \Router\src\classes\model\Game;
use Router\src\classes\model\GameNumbers;
use Router\src\classes\model\GameProcess;

/**
 * Класс отвечающий за игру
 * Class GameField
 */
class GameField extends CommonController
{
	/** @var int уникальный идентификатор игры */
	public $gameId;
	protected $tplName = '/GameField/GameField';
	protected $pageTitle = 'Игра номер';
	
	public function __construct($param = '')
	{
		if ($param) {
			$Session = new Session();
			$Session->start();
			$Session->set('gameId', $param);
		}
		$this->gameId = $param;
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
