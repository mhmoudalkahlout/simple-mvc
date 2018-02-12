<?php defined('__ROOT__') OR exit('No direct script access allowed');

class Controller
{
	public function __construct()
	{
		$this->view = new View();
	}
}
