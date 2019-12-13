<?php


namespace Router\src\classes\controller;


class PageNotFound extends CommonController
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
