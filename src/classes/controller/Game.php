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
		$this->toJSON([
			'result' => model\Game::createGame(),
		], true);

	}
}