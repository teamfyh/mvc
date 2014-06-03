<?php
if (!defined('HOST')) exit('Access Denied');


class Customer_ctrl extends Controller{
	public function Login($q){
		if($this->isAjax()){
			$this->model = $this->loadModel('customer');
			$this->view->d = $this->model->signin($q);
			$this->view->render('index');
		}
	}
}