<?php
if (!defined('HOST')) exit('Access Denied');


/**
* 
*/
class View
{
  var $d = array();
  public function __CONSTRUCT(){
    // $view = new View();
  }

  public function render($v = 'index',$fullLoad = false){

    if ($v) 
    {
      $d = $this->d;
      // include TPL . "modules" . EXT;
      // $d["modules"] = new Modules();

      $d["Headers"] = (isset($d["Headers"])) ? $this->loadHeaders($d["Headers"]) : $this->loadHeaders();
      echo $d["Headers"]["DOCTYPE"] . "\n";
      echo '<html lang="' . $d["Headers"]["LANG"] . '" >' . "\n";

      $this->loadHead($d);
      $this->loadBody($v, $d, $fullLoad);
      echo '</html>';
    } else  echo ('Nothing to Render');
  }

  public function loadHeaders($h = false) 
  {
    global $META;
    global $STYLESHEET;
    global $SCRIPT;

    $Headers = array();
    $Headers["DOCTYPE"] = (isset($h["DOCTYPE"])) ? $h["DOCTYPE"] : DOCTYPE;
    $Headers["TITLE"] = (isset($h["TITLE"])) ? $h["TITLE"] : TITLE;
    $Headers["CHARSET"] = (isset($h["CHARSET"])) ? $h["CHARSET"] : CHARSET;
    $Headers["LANG"] = (isset($h["LANG"])) ? $h["LANG"] : LANG;
    $Headers["FAVICON"] = (isset($h["FAVICON"])) ? $h["FAVICON"] : FAVICON;

    $Headers["META"] = (isset($h["META"])) ? array_merge($META, $h["META"]) : $META;

    $Headers["STYLESHEET"] = (isset($h["STYLESHEET"])) ? array_merge($STYLESHEET, $h["STYLESHEET"]) : $STYLESHEET;
    $Headers["SCRIPT"] = (isset($h["SCRIPT"])) ? array_merge($SCRIPT, $h["SCRIPT"]) : $SCRIPT;

    return $Headers;
  }

  public function loadHead($d) 
  {
    echo '<head>' . "\n";
    echo '<title>' . $d["Headers"]["TITLE"] . '</title>' . "\n";
    echo '<meta charset="' . $d["Headers"]["CHARSET"] . '">' . "\n";

        //METATAGS
    foreach ($d["Headers"]["META"] as $NAME => $CONTENT) echo '<meta name="' . $NAME . '" content="' . $CONTENT . '">' . "\n";

        //FAVICON
    if ($d["Headers"]["FAVICON"]) echo '<link rel="shortcut icon" href="' . IMG . $d["Headers"]["FAVICON"] . '">' . "\n";

        //STYLESHEETS
    foreach ($d["Headers"]["STYLESHEET"] as $HREF) $this->loadCSS($HREF);

        //SCRIPTS
    foreach ($d["Headers"]["SCRIPT"] as $SRC) $this->loadScript($SRC);

    echo '</head>' . "\n";
  }
  public function loadBody($view, $d = false, $fullLoad = false) 
  {
    echo '<body>';

    if (!$fullLoad && file_exists(TPL . 'header' . EXT)) include TPL . 'header' . EXT;

    if (file_exists(VW . $view . EXT))
      include VW . $view . EXT;
    else
      include TPL . '404' . EXT;

    if (!$fullLoad && file_exists(TPL . 'footer' . EXT)) include TPL . 'footer' . EXT;

    echo '</body>' . "\n";
  }

  public function loadCSS($src) 
  {
    echo '<link rel="stylesheet" href="' . CSS . THEME . $src . '">' . "\n";
  }

  public function loadScript($src) 
  {
    echo '<script type="text/javascript" src="' . JS . $src . '"></script>' . "\n";
  }

}