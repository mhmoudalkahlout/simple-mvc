<?php defined('__ROOT__') OR exit('No direct script access allowed');

require_once __ROOT_PATH__.'/third_party/rb.php';
class Setup_rb
{
	public function __construct($localhost = NULL, $dbname = NULL, $username = NULL, $password = NULL)
	{
		$localhost 	= $localhost? $localhost:__HOSTNAME__;
		$dbname 	= $dbname? $dbname:__DATABASE__;
		$username 	= $username? $username:__USERNAME__;
		$password 	= $password? $password:__PASSWORD__;
		R::setup( "mysql:host=$localhost;dbname=$dbname;charset=utf8", $username, $password);
		R::freeze( TRUE );
	}
}
