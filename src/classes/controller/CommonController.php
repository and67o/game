<?php


namespace Router\Controller;


use Router\Router;
use Router\src\classes\model\services\Cookie;
use Router\src\classes\model\User;

class CommonController
{
	/** @var int уникальный идентификатор пользователя */
	public $userId;
	/** @var User объект пользователя */
	public $User;
	
	/** Путь до шаблонов*/
	const BASE_TEMPLATE_PATH = 'src/templates/';
	
	function __construct()
	{
		$Cookie = new Cookie();
		$this->userId = $Cookie->exists('userId') ? $Cookie->get('userId') : 0;
		$this->User = $this->userId ? new User($this->userId) : [];
	}
	
	/**
	 * Получить ответ в формате JSON
	 * @param $var
	 * @param bool $send
	 * @return false|string
	 */
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
	
	/**
	 * Проверка на то, что запрос отправлен AJAX
	 * @return bool
	 */
	public function isAjax()
	{
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
	}
	
	/**
	 * редирект
	 * @param $location
	 * @param bool $condition
	 */
	protected function locationRedirect($location, $condition = true)
	{
		if ($condition) {
			header('Location: ' . $location);
			exit;
		}
		header('Location: /');
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
