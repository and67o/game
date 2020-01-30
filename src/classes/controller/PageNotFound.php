<?php


namespace Router\src\classes\controller;


use Router\src\classes\interfaces\BaseTwigController;

class PageNotFound extends BaseTwigController
{
	protected $tplName = 'pageNotFound/pageNotFound';
	protected $pageTitle = 'Страница не найдена';

	/**
	 * Страница 404
	 */
	public function index()
	{
		$this->render();
	}
	
}
