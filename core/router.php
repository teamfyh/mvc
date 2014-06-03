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
		//Parse the URL into Controller::Method?Params
		$this->urlParse($url);

		

		$ctrl = strtolower($this->controller);
		$method = strtolower($this->method);
		
		$r = $this->isCustomLink($ctrl.'::'.$method);
		if($r){
			$r = explode('::', $r);
			$ctrl = $r[0];
			$method = $r[1];
		}

		//FIND AND LOAD THE CONTROLLER
		if(!file_exists(CNT.$ctrl.EXT))
			// $this->redirect(ROOT.'404'); 
			echo 'Controller not found';
		else{
			require_once(CNT.$ctrl.EXT);
			$ctrlClass = $ctrl.'_ctrl';
			$methodClass = $method;
			
			if(class_exists($ctrlClass)){
				$controller = new $ctrlClass();
				if(method_exists($controller, $methodClass))
					$controller->$methodClass($this->params);
				else
					// $this->redirect(ROOT.'404');
					echo 'Method not found';
			}
			else
				// $this->redirect(ROOT.'404');
				echo 'Class not found';
		}
		
	}

	public function isCustomLink($Q) 
	{
		global $URLS;
		if (array_key_exists($Q, $URLS)) return $URLS[$Q];
		return false;
	}

	public function redirect($url)
	{
		if (!headers_sent())
		{    
			header('Location: '.$url);
			exit;
		}
		else
		{  
			echo '<script type="text/javascript">';
			echo 'window.location.href="'.$url.'";';
			echo '</script>';
			echo '<noscript>';
			echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
			echo '</noscript>'; exit;
		}
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
