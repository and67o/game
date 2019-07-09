<?php


namespace Router\src\classes\controller;


class Auth extends CommonController
{
	/**
	 * Страница авторизации
	 */
	public function index() {
		$this->render('auth');
	}
	
	/**
	 * Авторизация на сайте
	 */
	public function authorisation() {
		var_dump(222);
	}
}
