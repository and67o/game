<?php


namespace Router\src\classes\controller;


class CommonController
{

	public function render($namePage, $data='')
	{
		require 'src/templates/' . $namePage . '/' . $namePage . '.php';
	}

	public function redirectIfNotUser($isAdmin = false)
	{
		return (bool)$_COOKIE['user'];
	}

	public function toJSON($var, $send = false)
	{
		$result = json_encode($var);
		if ($send) {
			header('Content-Type: application/json; charset=utf-8');
			print($result);
			exit();
		}
		return $result;
	}

	public function isAjax()
	{
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
	}

	protected function locationRedirect($location, $condition = true)
	{
		if ($condition) {
			header('Location: ' . $location);
			exit;
		}
	}

}
