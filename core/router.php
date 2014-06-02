<?php
if (!defined('HOST')) exit('Access Denied');

/**
* 
*/
class Router
{
	public function urlParse($request){
		echo '<pre>';
		var_dump($request);
		$request = self::cleanURL(urldecode($_SERVER['REQUEST_URI']));
		var_dump($request);
		$request = substr( $request , 0 , strpos( $request , '?' , strpos( $request , '?' ) + 1 ) );
		$trailSearch = array('/=+/','/\/+/','/\?+/');
		$trailReplace = array('=','/','?');
		var_dump($request);
		$request = preg_replace($trailSearch, $trailReplace, $request);
		var_dump($request);

		echo '</pre>';

	}

	public function cleanURL($url){

		$url = stripslashes($url);
		$bad = array(
			'<',
			'>',
			'(',
				')',
		'script',
		'alert',
		'window',
		'javascript',
		'{',
		'}',
		'function',
		'document',
		'"',
		"'",
		);
		return str_replace($bad, "", $url);
	}
}
