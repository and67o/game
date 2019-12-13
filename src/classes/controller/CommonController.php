<?php


namespace Router\src\classes\controller;


use Router\Models\Cookie;
use Router\Models\User;
use Router\Router;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

class CommonController
{
	/** @var int уникальный идентификатор пользователя */
	public $userId;
	/** @var int объект пользователя */
	public $User;
	
	function __construct()
	{
		$Cookie = new Cookie();
		$this->userId = $Cookie->exists('userId') ? $Cookie->get('userId') : 0;
		$this->User = $this->userId ? new User($this->userId) : [];
	}
	
	/**
	 * Рендер Шаблона
	 * @param $file
	 * @param array $params
	 */
	public function render($file, $params = [])
	{
		$loader = new FilesystemLoader('src/templates/');
		$twig = new Environment($loader);
		try {
			echo $twig->render($file . '.twig', $params);
		} catch (LoaderError $e) {
			Router::getPage404();
//			var_dump($e);
		} catch (RuntimeError $e) {
//			var_dump(3333333);
			exit;
		} catch (SyntaxError $e) {
//			var_dump($e);
			exit;
		}
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
	
	/**
	 * Задает авторизационные куки
	 * @param int $userId
	 */
	public function setAuthCookie(int $userId)
	{
		Cookie::set('userId', $userId, strtotime('+30 days'));
	}
	
}
