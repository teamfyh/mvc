<?php
define('HOST', $_SERVER["SERVER_NAME"]);

// Load the Start Up Class
require_once('core/mvc.php');

MVC::Run();