<?php

namespace Router;

/**
 * Class Router
 * @package Router
 */
Class Router
{
	const PATH_CONTROLLER = '\Router\Controller\\';
	
	private static $defaultControllerName = 'MainPage';
	private static $defaultMethodName = 'index';
	private static $controller404 = 'PageNotFound';
	
	/**
	 * Роутер
	 */
	public function run()
	{
		$urlParts = explode('/', $_SERVER['REQUEST_URI']);
		
		array_shift($urlParts);
		
		//класс контроллера
		$fullControllerName = $this->_controller(array_shift($urlParts));
		
		//метод контроллера
		$methodName = $this->_methodName(array_shift($urlParts));
		
		//параметр
		$param = count($urlParts) ? array_shift($urlParts) : '';
		
		if (class_exists($fullControllerName) && method_exists($fullControllerName, $methodName)) {
			$Controller = new $fullControllerName($param);
			$Controller->$methodName();
			return;
		}
		
		self::getPage404();
	}
	
	/**
	 * @param string $methodName
	 * @return string
	 */
	private function _methodName($methodName) : string
	{
		$methodName = $methodName
			? ucfirst($methodName)
			: self::$defaultMethodName;
		
		if (strpos($methodName, '?')) {
			$methodName = stristr($methodName, '?', true);
		}
		return $methodName;
	}
	
	/**
	 * @param string $controllerName
	 * @return string
	 */
	private function _controller(string $controllerName) : string
	{
		$controllerName = $controllerName
			? ucfirst($controllerName)
			: self::$defaultControllerName;
		
		return self::PATH_CONTROLLER . $controllerName;
	}
	
	/**
	 * Показать 404
	 */
	public static function getPage404()
	{
		$fullControllerName = self::PATH_CONTROLLER . self::$controller404;
		$Controller = new $fullControllerName();
		$methodName = self::$defaultMethodName;
		$Controller->$methodName();
	}
}
