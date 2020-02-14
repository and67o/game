<?php


namespace Router\Controller;

use Exception;
use Router\Interfaces\BaseTwigController;
use Router\Models\GameNumbers;
use Router\Models\GameProcess;
use Router\Models\Services\Input;
use Router\Models\Services\Session;
use Router\Models\Game as GameModel;

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
        try {
            $data = Input::json(file_get_contents('php://input'));
            if (!$data) throw new Exception('Нет данных');

            $newNumber = (int) $data['number'];
    
            $Session = new Session();
            $Session->start();
    
            $gameId = $Session->exists('gameId') ? (int) $Session->get('gameId') : '';
            if (!$gameId) throw new Exception('Нет игры');
    
            $number = GameNumbers::getGameNumberByGameId($gameId);
            $resultOfMove = (new GameModel($number))->checkNumber($newNumber);
            GameProcess::saveMove([
                'g_id' => $gameId,
                'dt' => date('Y-m-d H:i:s'),
                'right_position' => $resultOfMove['rightPosition'],
                'right_count' => $resultOfMove['rightCount'],
                'move' => $newNumber
            ]);
            //TODO один шаблон ответа
            $this->toJSON($resultOfMove, true);
        } catch (Exception $exception) {
        
        }
	}
}
