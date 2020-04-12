<?php


namespace Router\Controller;

use Exception;
use Router\Interfaces\BaseTwigController;
use Router\Models\Game as GameModel;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class Game
 * @package Router\Controller
 */
class Game extends BaseTwigController
{
	
	protected $tplName = 'Game';
	protected $pageTitle = 'Игра';
	
	/**
	 *
	 */
	public function index() : void
	{
		try {
			$this->render();
		} catch (RuntimeError $e) {
		} catch (SyntaxError $e) {
		}
	}
	
	/**
	 * Создание новой игры
	 * @return void
	 * @throws Exception
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
