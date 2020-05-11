<?php


namespace Router\Abstractions;


use Router\Controller\CommonController;
use Router\Router;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

/**
 * Class BaseTwigController
 * @package Router\Interfaces
 */
abstract class BaseTwigController extends CommonController
{
	/** Путь до шаблонов*/
	const BASE_TEMPLATE_PATH = 'templates/';
	
	/** @var string назваине шаблона */
	protected $tplName;
	/** @var string название страницы */
	protected $pageTitle;
	
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 *
	 */
	abstract public function index() : void;
	
	/**
	 * Рендер шаблона
	 * @param array $params
	 * @throws RuntimeError
	 * @throws SyntaxError
	 */
	public function render($params = [])
	{
		$loader = new FilesystemLoader(self::BASE_TEMPLATE_PATH);
		$twig = new Environment($loader);
		$templateParams = array_merge(
			$this->getBaseParam($this->pageTitle),
			$params
		);

		try {
			echo $twig->render($this->_getTemplatePath(), $templateParams);
		} catch (LoaderError $e) {
			Router::getPage404();
		}
	}
	
	/**
	 * Получить путь к шаблону
	 * @return string
	 */
	private function _getTemplatePath()
	{
		return $this->tplName . '/index.twig';
	}
	
	/**
	 * Формирование параметров для шапки сайта
	 * @param string $namePage
	 * @return array
	 */
	public function getBaseParam(string $namePage) : array
	{
		$userData = [];
		if ($this->User) {
			$userData = [
				'email' => $this->User->email,
				'path' => $this->User->profileAvatar,
			];
		}
		$html = [
			'title' => $namePage,
		];
		return array_merge($html, $userData);
	}
	
}
