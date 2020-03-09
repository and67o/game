<?php

namespace Router\Controller;


use Router\Interfaces\BaseTwigController;
use Router\Models\Services\Hash;

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
	public function index()
	{
		$this->render();
	}

}
