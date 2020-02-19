<?php


namespace Router\Controller;


use Router\Interfaces\BaseTwigController;

/**
 * Страница Профиля
 * Class ProfileController
 * @package Router\Controller
 */
class Profile extends BaseTwigController
{
	
	protected $tplName = 'Profile/profile';
	protected $pageTitle = 'Профиль';
	
	/**
	 * Главная профиля
	 */
	public function index()
	{
		$this->render();
	}
}
