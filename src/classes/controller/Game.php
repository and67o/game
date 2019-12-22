<?php


namespace Router\src\classes\controller;

use Router\src\classes\model\GameNumbers;
use Router\src\classes\model\services\Session;


class Game extends CommonController
{
	
	protected $tplName = '/Game/Game';
	protected $pageTitle = 'Игра';
	
	public function index()
	{
		$this->render();
	}
	
	/**
	 * Создание новой игры
	 * @return void
	 */
	public function createGame()
	{
		$gameId = \Router\src\classes\model\Game::createGame();
		$userId = $this->userId ? : 0;
		$createNumber = $gameId > 0 ? GameNumbers::writeNumber($gameId, $userId) : false;
		if ($createNumber) {
			$Session = new Session();
			$Session->start();
			$Session->set('gameId', $gameId);
		}
		$this->locationRedirect('/GameField/index/' . $gameId);
	}
}
