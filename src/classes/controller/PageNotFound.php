<?php


namespace Router\src\classes\controller;


class PageNotFound extends CommonController
{
	
	/**
	 * Страница 404
	 */
	public function index()
	{
		$permanentValues = $this->getBaseParam('Страница не найдена');
		$paramsForPage = [];
		$this->render('pageNotFound/pageNotFound',
			array_merge(
				$permanentValues,
				$paramsForPage
			)
		);
	}
	
}
