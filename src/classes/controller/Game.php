<?php


namespace Router\src\classes\controller;

use Router\src\classes\interfaces\BaseFacade;
use Router\src\classes\model;


class Game extends CommonController implements BaseFacade
{
	
	public function index()
	{
		$this->render('/Game/Game', [
			'title' => 'Игра'
		]);
	}
	
	/**
	 * Создание новой игры
	 * @return void
	 */
	public function createGame()
	{
		var_dump(222);exit;
		$this->locationRedirect('/', !$this->isAjax());
		$gameId = model\Game::createGame();
		$userId = $this->userId ? : 0;
		$createNumber = $gameId > 0 ? model\Game::writeNumber($gameId, $userId) : false;
		$this->toJSON([
			'gameId' => $createNumber ? $gameId : 0,
		], true);
		
	}
}
