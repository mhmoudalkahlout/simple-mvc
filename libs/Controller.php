<?php defined('__ROOT__') OR exit('No direct script access allowed');

require_once __ROOT_PATH__.'/third_party/rb.php';
class Controller
{
	public function __construct()
	{
		$this->view = new View();
		R::setup( 'mysql:host='.__HOSTNAME__.';dbname='.__DATABASE__, __USERNAME__, __PASSWORD__ );
		R::freeze( TRUE );
	}
}
