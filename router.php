<?php

namespace Router;


Class Router
{

	private static $controllerName = 'MainPage';
	private static $defaultName = 'index';

	public function run()
	{
		$url = $_SERVER['REQUEST_URI'];
//		if ($url == '/js/jquery-3.2.1.min.js') {
//			return true;
//		}
//		if ($url == '/js/gameField.js') {
//			return true;
//
//		}

		$controllerName = '';
		$methodName = '';
		$urlParts = explode('/', $url);
		if (count($urlParts) == 3) {
			$controllerName = lcfirst($urlParts[1]);
			$methodName = $urlParts[2];
		} elseif (count($urlParts) == 2) {
			$controllerName = $urlParts[1] ? lcfirst($urlParts[1]) : self::$controllerName;
			$methodName = self::$defaultName;
		}
		$fullControllerName = '\Router\src\classes\controller\\' . ucfirst($controllerName);
		$Controller = new $fullControllerName();

		$Controller->$methodName();
	}
}