<?php defined('__ROOT__') OR exit('No direct script access allowed');

class Home extends My_controller
{
	public function index()
	{
		$this->view->title = __SITE_NAME__ . ' - Home';
		$this->view->render('home');
	}
}
