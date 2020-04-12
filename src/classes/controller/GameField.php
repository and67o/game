<?php


namespace Router\Controller;

use Exception;
use Router\Interfaces\BaseTwigController;
use Router\Models\{
	GameProcess,
	GameNumbers,
	Model
};
use Router\Models\Services\Input;
use Router\Models\Game as GameModel;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Класс отвечающий за игру
 * Class GameField
 */
class GameField extends BaseTwigController
{
	/** @var int уникальный идентификатор игры */
	public $gameId;
	
	protected $tplName = 'GameField';
	protected $pageTitle = 'Игра номер';
	
	public function __construct($gameId = '')
	{
		parent::__construct();
		
		if (!$this->isAuth() || !$gameId) {
			$this->toMain();
		}
		$this->gameId = $gameId;
		$this->pageTitle = 'Игра номер ' . $this->gameId;
	}
	
	/**
	 * Главная страница игры
	 */
	public function index() : void
	{
		try {
			$this->render([
				'moves' => GameProcess::getAllInformByGame($this->gameId) ? : []
			]);
		} catch (RuntimeError $e) {
		} catch (SyntaxError $e) {
		}
	}
	
	/**
	 * Метод добавления нового числа
	 */
	public function addNewNumber()
	{
		try {
			$this->Input->setInputParam(
				file_get_contents('php://input'),
				Input::METHOD_REQUEST_POST
			);
			
			if (!$this->Input->checkRequestMethod()) {
				throw new Exception('Нет данных');
			}
			
			$newNumber = $this->Input->get('number', 'int');
			
			if (!$this->gameId) {
				throw new Exception('Нет игры');
			}
			
			$number = GameNumbers::getGameNumberByGameId($this->gameId);
			$GameModel = new GameModel($number);
			$resultOfMove = $GameModel->checkNumber($newNumber);
			
			$this->_saveMove($resultOfMove, $newNumber);
			
			$this->toJSON($this->response(
				[],
				true,
				$resultOfMove
			), true);
		} catch (Exception $exception) {
			$this->toJSON($this->response(
				$exception->getMessage(),
				false
			), true);
		}
	}
	
	/**
	 * @param $resultOfMove
	 * @param $newNumber
	 * @throws Exception
	 */
	private function _saveMove($resultOfMove, $newNumber)
	{
		GameProcess::saveMove([
			'g_id' => $this->gameId,
			'dt' => Model::now(),
			'right_position' => $resultOfMove['rightPosition'],
			'right_count' => $resultOfMove['rightCount'],
			'move' => $newNumber
		]);
	}
}
