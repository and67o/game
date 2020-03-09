<?php


namespace Router\Controller;

use Router\Exceptions\BaseException;
use Router\Interfaces\BaseTwigController;
use Router\Models\Game as GameModel;


class Game extends BaseTwigController
{
	
	protected $tplName = 'Game';
	protected $pageTitle = 'Игра';
	
	public function index()
	{
		$this->render();
	}
	
	/**
	 * Создание новой игры
	 * @return void
	 * @throws \Exception
	 */
	public function createGame()
	{
		$Game = new GameModel();
		if ($this->User->userId) {
			$gameId = $Game->createFullGame($this->User->userId);
			$this->locationRedirect('/GameField/index/' . $gameId, $gameId);
		}
		$this->toMain();
	}
}
