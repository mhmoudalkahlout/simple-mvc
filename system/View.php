<?php defined('__ROOT__') OR exit('No direct script access allowed');

class View
{
	public function __construct()
	{
		
	}
	
	public function render($viewPath)
	{
		if ($viewPath == 'error/index')
			require("views/$viewPath.php");
		else {
			$this->view = $viewPath;
			require('views/layout.php');
		}	
	}
}
