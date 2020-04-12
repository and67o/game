<?php

namespace Router\Controller;


use Router\Interfaces\BaseTwigController;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Главная страница
 * Class MainPage
 * @package Router\src\classes\controller
 */
class MainPage extends BaseTwigController
{
	
	protected $tplName = 'MainPage';
	protected $pageTitle = 'Главная';
	
	/**
	 * Главная страницы
	 */
	public function index() : void
	{
		try {
			$this->render();
		} catch (RuntimeError $e) {
		} catch (SyntaxError $e) {
		}
	}
	
}
