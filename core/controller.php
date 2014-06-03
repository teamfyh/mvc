<?php
if (!defined('HOST')) exit('Access Denied');


/**
* 
*/
class Controller
{
  var $model = null;
	var $view = null;
  public function __CONSTRUCT(){
    $this->view = new View();
  }

  public function loadModel($m) 
  {
    if (isset($m)) 
    {

      if (file_exists(MDL . $m . EXT)) 
      {
        require_once (MDL . $m . EXT);

        $mdl = $m . '_mod';
        if (class_exists($mdl)) return new $mdl();
        else return NULL;
      }
    } else return NULL;
  }

  public function isAjax() 
  { 
    if (isset($_SERVER["HTTP_REFERER"])) return true;
    else
    {
      header('location:' . DB . '404');
      return false;
    }
  }
}