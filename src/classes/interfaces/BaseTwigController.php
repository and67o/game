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
	
	public function __construct()
	{
		parent::__construct();
	}
	
	/** @var string назваине шаблона */
	protected $tplName;
	/** @var string название страницы */
	protected $pageTitle;
	
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
		try {
			echo $twig->render(
				$this->_getTemplatePath(),
				array_merge(
					$this->getBaseParam($this->pageTitle),
					$params
				)
			);
		} catch (LoaderError $e) {
			Router::getPage404();
		}
	}

    /**
     * Получить путь к шаблону
     * @return string
     */
	private function _getTemplatePath() {
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
