<?php


namespace Router\src\classes\controller;


class MainPage extends CommonController
{

	public function index()
	{
		$this->render('MainPage');
	}
}