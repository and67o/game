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
	
	public function __construct()
	{
		$this->setInput();
		$this->setValidation();
		$this->setSession();
		$this->setUser();
	}
	
	/**
	 * @return void
	 */
	public function setInput()
	{
		$this->Input = new Input();
	}
	
	/**
	 * @return void
	 */
	public function setValidation()
	{
		$this->Validation = new Validation();
	}
	
	/**
	 * @return void
	 */
	public function setSession()
	{
		$this->Session = new Session();
	}
	
	/**
	 * @return void
	 */
	public function setUser()
	{
		$this->User = new User();
	}
	
	/**
	 * Редирект
	 * @param $location
	 * @param bool $condition
	 * @return void
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
	 * @return void
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
