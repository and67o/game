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
	
	protected $tplName = 'Profile';
	protected $pageTitle = 'Профиль';
	
	/**
	 * страница профиля
	 */
	public function index()
	{
		$this->render();
	}
}
