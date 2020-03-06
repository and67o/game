<?php


namespace Router\Controller;

use Exception;
use Router\Interfaces\BaseTwigController;
use Router\Models\GameNumbers;
use Router\Models\GameProcess;
use Router\Models\Model;
use Router\Models\Services\Input;
use Router\Models\Game as GameModel;

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
		if ($gameId) {
            $this->Session->start();
            $this->Session->set('gameId', $gameId);
		}
		$this->gameId = $gameId;
		$this->pageTitle = 'Игра номер ' . $this->gameId;
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
        try {
            $this->Input->setInputParam(
                file_get_contents('php://input'),
                Input::METHOD_REQUEST_POST
            );
            
            if (!$this->Input->checkRequestMethod()) throw new Exception('Нет данных');

            $newNumber = $this->Input->get('number', 'int');
    
            $this->Session->start();
    
            $gameId = $this->Session->exists('gameId')
                ? (int) $this->Session->get('gameId')
                : 0;
            if (!$gameId) throw new Exception('Нет игры');
    
            $number = GameNumbers::getGameNumberByGameId($gameId);
            $GameModel = new GameModel($number);
            $resultOfMove = $GameModel->checkNumber($newNumber);
            
            $this->_saveMove($gameId, $resultOfMove, $newNumber);
            
            $this->toJSON($this->response(
                [],
                true,
                $resultOfMove
            ),true);
        } catch (Exception $exception) {
            $this->toJSON($this->response(
                $exception->getMessage(),
                false
            ),true);
        }
	}
    
    /**
     * @param $gameId
     * @param $resultOfMove
     * @param $newNumber
     * @throws Exception
     */
	private function _saveMove($gameId, $resultOfMove, $newNumber) {
        GameProcess::saveMove([
            'g_id' => $gameId,
            'dt' => Model::now(),
            'right_position' => $resultOfMove['rightPosition'],
            'right_count' => $resultOfMove['rightCount'],
            'move' => $newNumber
        ]);
    }
}
