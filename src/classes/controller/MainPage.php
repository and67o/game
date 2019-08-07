<?php


namespace Router\src\classes\controller;

/**
 * Главная страница
 * Class MainPage
 * @package Router\src\classes\controller
 */
class MainPage extends CommonController
{
	/**
	 * Главная страницы
	 */
	public function index()
	{
		$permanentValues = $this->headerParams('Главная');
		$paramsForPage = [];
		$this->render('MainPage', array_merge($permanentValues, $paramsForPage));
	}
}
