<?php
if (!defined('HOST')) exit('Access Denied');


class customer_mod extends Model{
	function signin($q){
		return $this->getRow("SELECT `username`,`userid`,UPPER(CONCAT(`title`, '. ', `firstname`,' ',`lastname`)) as userfullname FROM `u_customeracct` WHERE `username`='".$q['username']."' AND `password`='".$this->cipher($this->clean($q['password']))."'");
	}
}