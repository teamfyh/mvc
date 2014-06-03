<?php
if (!defined('HOST')) exit('Access Denied');


class index_mod extends Model{
	function index($q){
		return $this->GetAll('SELECT * FROM f_products LIMIT 3');			
	}
}