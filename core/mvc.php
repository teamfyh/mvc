<?php
if (!defined('HOST')) exit('Access Denied');

/**
* Core - Start Up File
*/
class MVC
{
	
    private function __construct() {}
    private function __destruct() {}
    private function __clone() {}

	function Run()
	{
		$file_configuration = 'core/config.php';

		if (!file_exists($file_configuration)) 
			exit('Unable to Start.Cannot find configuration file.');
			
		include $file_configuration;
		self::AutoLoad($files_core);
		Router::urlParse($_SERVER['REQUEST_URI']);
	}

	function AutoLoad($files){

		if(!is_array($files))
			exit('System core files missing.');
		
		foreach ($files as $file) 
		{
			//Require all existing core files in the configuration.php
			if (!file_exists(CORE . $file . EXT)) exit('FILE : Missing - ' . $file);
			else require (CORE . $file . EXT);
		}
	}
}