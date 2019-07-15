<?php


namespace Router\src\classes\controller;


class MainPage extends CommonController
{
	public function index()
	{
		$html = array('TITLE' => 'Добро пожаловать!');
		$this->render('MainPage', $html);
	}
}
