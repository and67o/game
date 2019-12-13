<?php


namespace Router\src\classes\controller;

use Router\src\classes\model;


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
		$gameId = model\Game::createGame();
		$userId = $this->userId ? : 0;
		$createNumber = $gameId > 0 ? model\Game::writeNumber($gameId, $userId) : false;
		$this->locationRedirect('/GameField/index/' . $gameId);
		
	}
}
