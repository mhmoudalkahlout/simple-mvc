<?php defined('__ROOT__') OR exit('No direct script access allowed');

require_once __ROOT_PATH__.'/third_party/rb.php';
class My_rb
{
	public function __construct()
	{
		R::setup( 'mysql:host='.__HOSTNAME__.';dbname='.__DATABASE__, __USERNAME__, __PASSWORD__ );
		R::freeze( TRUE );
	}
}
