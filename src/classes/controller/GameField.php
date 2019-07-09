<?php


namespace Router\src\classes\controller;

use \Router\src\classes\model\Game;


class GameField extends CommonController
{
	public function index()
	{
		$this->render('GameField');
	}

	public function createGame() {
		$this->toJSON([
			'result' => Game::createGame(),
		], true);
	}

	public function addNewNumber() {
		$newNumber = (int) $_POST['number'];
		$Game = new Game(3456);
		$rightPosition = $Game->checkNumber($newNumber);
		$this->toJSON($rightPosition, true);
	}
}