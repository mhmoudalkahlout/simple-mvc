<?php defined('__ROOT__') OR exit('No direct script access allowed');

class Users extends My_controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->view->title = 'users';
        $this->view->data['allUsers'] = R::findAll( 'users' );
		$this->view->render('users/view');
	}
}
