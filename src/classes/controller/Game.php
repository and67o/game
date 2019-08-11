<?php


namespace Router\src\classes\controller;

use Router\src\classes\model;


class Game extends CommonController
{

	public function index()
	{
		$this->render('Game');
	}

	/**
	 * Создание новой игры
	 * @return void
	 */
	public function createGame() {
		$this->locationRedirect('/', !$this->isAjax());
		$gameId = model\Game::createGame();
		$createNumber = $gameId > 0 ? model\Game::writeNumber($gameId) : false;
		$this->toJSON([
			'gameId' => $createNumber ? $gameId : 0,
		], true);

	}
}
