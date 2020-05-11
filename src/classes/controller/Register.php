<?php

namespace Router\Controller;


use Router\Exceptions\{
	BaseException,
	ErrorException
};
use Router\Models\Services\{
	Input
};
use Router\Models\{
	Auth,
	Validation,
};
use PDOException;
use Router\Facades\UserFacade;

/**
 * Класс отвечающий за регистрацию
 * Class Register
 */
class Register extends CommonController
{
	/**
	 * Регистрация пользователя
	 */
	public function register()
	{
		try {
			$this->setResponse(Input::METHOD_REQUEST_POST);
			
			if (!$this->Input->checkRequestMethod()) {
				throw new BaseException(BaseException::WRONG_METHOD);
			}
			
			$errors = $this->_validateParam();
			if ($errors) {
				throw new ErrorException($errors);
			}
			
			$userId = UserFacade::add(
				$this->Input->get('email', 'string'),
				$this->Input->get('password', 'string'),
				$this->Input->get('name', 'string')
			);
			
			if (!$userId) {
				throw new BaseException(BaseException::USER_NOT_CREATED);
			}
			
			Auth::setAuthCookie('userId', $userId);
			$this->Session->start();
			$this->Session->set('userId', $userId);
			
			$this->toJSON($this->response(
				[],
				(bool) $userId
			), true);
			
		} catch (PDOException $e) {
			
			$this->toJSON($this->response(
				[$e->getMessage()],
				false
			), true);
			
		} catch (BaseException $BaseException) {
			
			$this->toJSON($this->response(
				[
					'default' => $BaseException->getTextError()
				],
				false
			), true);
		}
	}
	
	/**
	 * Валидация данных
	 * @return bool|mixed
	 */
	private function _validateParam()
	{
		$email = $this->Input->get('email', 'string');
		$password = $this->Input->get('password', 'string');
		$name = $this->Input->get('name', 'string');
		
		$this->_baseValidate($email, 'email')->isExist()->isValidateEmail();
		$this->_baseValidate($password, 'password');
		$this->_baseValidate($name, 'name');
		return $this->Validation->isSuccess()
			? false
			: $this->Validation->getErrors();
	}
	
	/**
	 * @param $data
	 * @param $nameField
	 * @return Validation
	 */
	private function _baseValidate($data, $nameField)
	{
		return $this->Validation
			->setName($nameField)
			->setValue($data)
			->required()
			->min()
			->max();
	}
}
