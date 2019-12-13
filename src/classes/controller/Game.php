<?php


namespace Router\src\classes\controller;

use Router\src\classes\model;


class Game extends CommonController
{
	
	public function index()
	{
		$permanentValues = $this->getBaseParam('Игра');
		$paramsForPage = [];
		$this->render('/Game/Game',
			array_merge(
				$permanentValues,
				$paramsForPage
			)
		);
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
