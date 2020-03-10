<?php

namespace Router\Controller;

use Router\Interfaces\BaseTwigController;

/**
 * Class PageNotFound
 * @package Router\Controller
 */
class PageNotFound extends BaseTwigController
{
	protected $tplName = 'pageNotFound';
	protected $pageTitle = 'Страница не найдена';

	/**
	 * Страница 404
	 */
	public function index()
	{
		$this->render();
	}
	
}
