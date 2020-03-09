<?php


namespace Router\Controller;

use Router\Models\{
	User,
	Validation
};
use Router\Models\Services\{
	Input,
	Session,
	Cookie
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

	/** Путь до шаблонов*/
	const BASE_TEMPLATE_PATH = 'src/templates/';
    
    function __construct()
	{
	    $this->Input = new Input();
	    $this->Validation = new Validation();
		$this->Session = new Session();
		
		//TODO убрать исправить на сессию
		$Cookie = new Cookie();
		$this->userId = $Cookie->exists('userId') ? $Cookie->get('userId') : 0;
		$this->User = new User($this->userId);
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
     * @param $errors
     * @param bool $result
     * @param array $data
     * @return array
     */
	protected function response($errors, bool $result, array $data = []) :array
    {
	   return [
	       'errors' => $errors,
           'result' => $result,
           'data' => $data
       ];
    }
}
