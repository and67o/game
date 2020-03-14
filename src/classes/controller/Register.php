<?php

namespace Router\Controller;

use Exception;

use Router\Exceptions\{
	BaseException,
	ErrorException
};
use Router\Models\Services\{
	Hash,
	Input
};
use Router\Models\{
	Model,
	Auth,
	Validation,
	Role
};
use PDOException;

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
			$this->Input->setInputParam(
				file_get_contents('php://input'),
				Input::METHOD_REQUEST_POST
			);
			
			if (!$this->Input->checkRequestMethod()) {
				throw new BaseException(BaseException::WRONG_METHOD);
			}
			
			$errors = $this->_validateParam();
			if ($errors) {
				throw new ErrorException($errors);
			}
			
			$userId = $this->createUser();
			if (!$userId) {
				throw new PDOException('Проблемы с регистрацией');
			}
			
			Auth::setAuthCookie('userId', $userId);
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
		} catch (Exception $e) {
		}
	}
	
	/**
	 * Создать пользователя
	 * @return int
	 * @throws Exception
	 */
	private function createUser()
	{
		$hashes = Hash::passwordHash($this->Input->get('password', 'string'));
		
		return (int) $this->User->create([
				'email' => $this->Input->get('email', 'string'),
				'password' => $hashes['hash'],
				'salt' => $hashes['salt'],
				'name' => $this->Input->get('name', 'string'),
				'reg_dt' => Model::now(),
				'role_id' => Role::USER_ROLE,
			]) ?? 0;
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
