<?php

namespace Router;



Class Router
{
	const PATH_CONTROLLER = '\Router\src\classes\controller\\';

	private static $defaultControllerName = 'MainPage';
	private static $defaultMethodName = 'index';
	private static $controller404 = 'Controller404';

	/**
	 *
	 * Роутер
	 */
	public function run()
	{
		$urlParts = explode('/', $_SERVER['REQUEST_URI']);
		//класс контроллера
		array_shift($urlParts);
		$controllerName = array_shift($urlParts);
		$controllerName = $controllerName ? ucfirst($controllerName) : self::$defaultControllerName;
		//метод контроллера
		$methodName = array_shift($urlParts);
		$methodName = $methodName ? ucfirst($methodName) : self::$defaultMethodName;
		$fullControllerName = self::PATH_CONTROLLER . $controllerName;
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
	 * Показать 404
	 */
	public function getPage404() {
		$fullControllerName = self::PATH_CONTROLLER . self::$controller404;
		$Controller = new $fullControllerName();
		$methodName = self::$defaultMethodName;
		$Controller->$methodName();
	}
}
