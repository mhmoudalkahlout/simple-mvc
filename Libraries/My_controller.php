<?php defined('__ROOT__') OR exit('No direct script access allowed');

class My_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
		new Setup_rb();
	}
}
