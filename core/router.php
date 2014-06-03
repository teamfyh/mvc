<?php
if (!defined('HOST')) exit('Access Denied');

/**
* 
*/
class Router
{
	public  $controller = 'index';
	public  $method = 'index';
	public  $params = array();

	public function urlParse($request){
		
		//DECODE THE URL FOR SPECIAL CHARACTERS
		$request = self::cleanURL(urldecode($_SERVER['REQUEST_URI']));
		
		//TRIM THE URL AFTER SECOND OCCURENCE OF '?' TO AVOID PARAMETER CONFLICTS
		if(strpos( $request , '?' , strpos( $request , '?' ) + 1 ))
			$request = substr( $request , 0 , strpos( $request , '?' , strpos( $request , '?' ) + 1 ) );
		
		//MERGE DUPLICATE CHARACTERS
		$trailSearch = array('/=+/','/\/+/','/\?+/');
		$trailReplace = array('=','/','?');
		$request = preg_replace($trailSearch, $trailReplace, $request);
		
		//TRIM LEADING AND TRAILING '/'
		$request = trim($request,'/');

		//SPLIT REQUEST AND PARAMETERS
		$requestArray = explode('?', $request);

		//EXPLODE URL REQUEST INTO CONTROLLER::METHOD
		$controllArray = explode('/', $requestArray[0]);
		//OPTIONAL - SHIFT FIRST ARRAY ENTRY ( IF HOST HAS A SUBFOLDER )
		array_shift($controllArray);

		//SET IF CONTROLLER EXIST , ELSE SET AS INDEX
		$this->controller = isset($controllArray[0]) ? self::cleanString($controllArray[0]) : 'index';

		//SET IF METHOD EXIST , ELSE SET AS INDEX
		$this->method = isset($controllArray[1]) ? self::cleanString($controllArray[1]) : 'index';

		//IF PARAMETERS EXIST , EXPLODE INTO ARRAY
		$paramArray = (isset($requestArray[1]) && !empty($requestArray[1])) ? explode('&', $requestArray[1]) : array();

		
		if(count($paramArray)>0){

			foreach ($paramArray as $key => $value) {
				$v = explode('=', $value);
				$this->params[self::cleanString($v[0])] = (isset($v[1])) ? self::cleanString($v[1]) : null;
			}
		}
		


	}

	public function dispatch($url){
		$this->urlParse($url);


		//ECHO TESTING
		echo '<pre>';
		echo 'CONTROLLER : '.$this->controller.'<br>';
		echo 'METHOD : '.$this->method.'<br>';
		echo 'PARAMETERS : ';
		var_dump($this->params);
		echo '</pre>';
	}

	public function cleanString($string){
		//RETURNS A STRING WITH ALPHANUMERIC ONLY
		return trim(preg_replace("/[\W_]*/", '', $string));
	}

	public function cleanURL($url){
		//RETURNS A STRING WITH BAD STRING REMOVED
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
