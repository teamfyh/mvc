<?php
if (!defined('HOST')) exit('Access Denied');


class Index_ctrl extends Controller{
	public function Index($q=array())
	{
		$this->model = $this->loadModel('index');
		$this->view->d = $this->model->index($q);
		$this->view->render('index');
	}

	public function show404(){
		$this->view->render('templates/404');
	}
}