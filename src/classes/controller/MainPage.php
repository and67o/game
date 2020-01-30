<?php

namespace Router\src\classes\controller;

use Router\src\classes\interfaces\BaseTwigController;

/**
 * Главная страница
 * Class MainPage
 * @package Router\src\classes\controller
 */
class MainPage extends BaseTwigController
{
	
	protected $tplName = 'MainPage/MainPage';
	protected $pageTitle = 'Главная';
	
	/**
	 * Главная страницы
	 */
	public function index()
	{
		$this->render();
	}

}
