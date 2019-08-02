<?php


namespace Router\src\classes\controller;


class CommonController
{
	
	public function render($file, $params = [], $return = false) {
		$template  = 'src/templates/'. $file . '/' . $file .'.php';
		extract($params);
		ob_start();
		include ($template);
		if ($return) {
			return ob_get_clean();
		} else {
			echo ob_get_clean();
		}
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
