<?php

namespace Router\Controller;

use Router\Interfaces\BaseTwigController;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

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
		try {
			$this->render();
		} catch (RuntimeError $e) {
		} catch (SyntaxError $e) {
		}
	}
	
}
