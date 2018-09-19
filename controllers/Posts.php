<?php defined('__ROOT__') OR exit('No direct script access allowed');

class Posts extends My_controller
{
	public function index()
	{
		$this->view->allPosts = Post::all();
		$this->view->title = 'posts';
		$this->view->render('posts/view');
	}
}
