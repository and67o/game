<?php


namespace Router\src\classes\controller;

use Router\src\classes\interfaces\BaseTwigController;
use Router\src\classes\model\GameNumbers;
use Router\src\classes\model\services\Session;
use \Router\src\classes\model;


class Game extends BaseTwigController
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
		$Game = new model\Game();
		$gameId = $Game->createFullGame($this->userId);
		$this->locationRedirect('/GameField/index/' . $gameId, $gameId);
	}
}
