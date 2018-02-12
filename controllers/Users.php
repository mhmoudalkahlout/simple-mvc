<?php defined('__ROOT__') OR exit('No direct script access allowed');

class Users extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		new My_rb();
		$this->view->allUsers = R::findAll( 'users' );
		$this->view->title = 'users';
		$this->view->render('users/view');
	}
}
