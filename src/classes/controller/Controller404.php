<?php


namespace Router\src\classes\controller;


class Controller404 extends CommonController
{
	
	/**
	 * Страница 404
	 */
	public function index()
	{
		$this->render('pageNotFound');
	}
	
}
