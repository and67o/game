<?php


namespace Router\Controller;

use Router\Models\{
	User,
	Validation
};
use Router\Models\Services\{
	Input,
	Session
};
use Router\Traits\JsonTrait;

class CommonController
{
	
	use JsonTrait;
	
	/** @var int уникальный идентификатор пользователя */
	public $userId;
	/** @var User объект пользователя */
	protected $User;
	/** @var Input */
	protected $Input;
	/** @var Validation */
	protected $Validation;
	/** @var Session */
	protected $Session;
	
	function __construct()
	{
		$this->Input = new Input();
		$this->Validation = new Validation();
		$this->Session = new Session();
		$this->User = new User();
	}
	
	/**
	 * Редирект
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
	 * Редирект на главную
	 */
	protected function toMain()
	{
		header('Location: /');
	}
	
	/**
	 * @return bool
	 */
	protected function isAuth() : bool
	{
		return $this->User->userId > 0;
	}
	
	/**
	 * @param $errors
	 * @param bool $result
	 * @param array $data
	 * @return array
	 */
	protected function response($errors, bool $result, array $data = []) : array
	{
		return [
			'errors' => $errors,
			'result' => $result,
			'data' => $data
		];
	}
}
