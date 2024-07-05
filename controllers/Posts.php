<?php defined('__ROOT__') OR exit('No direct script access allowed');

class Posts extends My_controller
{
	public function index()
	{
		$this->view->title = 'posts';
        $this->view->data['allPosts'] = Post::all();
		$this->view->render('posts/view');
	}
}
