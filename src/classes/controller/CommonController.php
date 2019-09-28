<?php


namespace Router\src\classes\controller;


use Router\Models\User;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class CommonController
{
	/** @var int уникальный идентификатор пользователя */
	public $userId;
	/** @var int объект пользователя */
	public $User;

	function __construct()
	{
		$this->userId = isset($_COOKIE['userId']) ? $_COOKIE['userId'] : 0;
		$this->User = $this->userId ? new User($this->userId) : [];
	}

	public function render($file, $params = [], $return = false) {
		$loader = new FilesystemLoader( 'src/templates/'. $file);
		$twig = new Environment($loader);
		echo $twig->render($file . '.php', [
			'oleg' => 23
		]);
	}

	public function redirectIfNotUser($isAdmin = false)
	{
		return (bool) $_COOKIE && $_COOKIE['userId'];
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

	/**
	 * Формирование параметров для шапки сайта
	 * @param string $namePage
	 * @return array
	 */
	public function headerParams(string $namePage) : array {
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
	
	/**
	 * Задает авторизационные куки
	 * @param int $userId
	 */
	public function setAuthCookie(int $userId)
	{
		setcookie('userId', $userId, strtotime( '+30 days' ), '/');
	}

}
