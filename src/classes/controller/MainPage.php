<?php


namespace Router\src\classes\controller;

use Router\src\classes\interfaces\BaseFacade;

/**
 * Главная страница
 * Class MainPage
 * @package Router\src\classes\controller
 */
class MainPage extends CommonController implements BaseFacade
{
	/**
	 * Главная страницы
	 */
	public function index()
	{
		$permanentValues = $this->getBaseParam('Главная');
		$paramsForPage = [];
		$this->render('MainPage/MainPage',
			array_merge(
				$permanentValues,
				$paramsForPage
			)
		);
	}
}
