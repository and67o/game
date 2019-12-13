<?php


namespace Router\src\classes\controller;

use Router\Models\Input;
use Router\Models\Session;
use \Router\src\classes\model\Game;

/**
 * Класс отвечающий за игру
 * Class GameField
 */
class GameField extends CommonController
{
	/** @var int уникальный идентификатор игры */
	public $gameId;
	protected $tplName = '/Game/Game';
	protected $pageTitle = 'Игра номер';
	
	public function __construct($param = '')
	{
		if ($param) {
			$Session = new Session($_SESSION);
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
			'moves' => Game::GetAllInformByGame($this->gameId) ?: []
		]);
	}
	
	/**
	 * Ajax Метод добавления нового числа
	 */
	public function addNewNumber()
	{
		$data = Input::json(file_get_contents('php://input'));
		$newNumber = (int) $data['number'];

		$Session = new Session($_SESSION);
		$Session->start();

		$gameId = $Session->exists('gameId') ? (int) $Session->get('gameId') : '';
		$rightPosition = [];
		if ($gameId) {
			$number = Game::getGameNumberByGameId($gameId);
			$Game = new Game($number);
			$rightPosition = $Game->checkNumber($newNumber);

			$Game->saveMove([
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
