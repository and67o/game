<?php


namespace Router\Interfaces;


use Router\Controller\CommonController;
use Router\Router;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

abstract class BaseTwigController extends CommonController
{
	
	/** @var string назваине шаблона */
	protected $tplName;
	/** @var string название страницы */
	protected $pageTitle;
	
	/**
	 * Рендер Шаблона
	 * @param array $params
	 * @throws RuntimeError
	 * @throws SyntaxError
	 */
	public function render($params = [])
	{
		$loader = new FilesystemLoader(self::BASE_TEMPLATE_PATH);
		$twig = new Environment($loader);
		try {
			echo $twig->render(
				$this->tplName . '.twig',
				array_merge(
					$this->getBaseParam($this->pageTitle),
					$params
				)
			);
		} catch (LoaderError $e) {
			Router::getPage404();
		}
	}
}
