<?php
if (!defined('HOST')) exit('Access Denied');


//DIRECTORY CONSTANTS
define('ROOT', $_SERVER["REQUEST_SCHEME"].'://' . HOST . '/');

define('EXT', ".php");
define('DS', '/');

define('CORE', 'core'.DS);
define('APPL', 'application'.DS);

define('MDL', APPL . 'models/');
define('VW', APPL . 'views/');
define('RS', APPL . 'resources/');
define('TPL', VW . 'templates/');
define('CNT', APPL . 'controllers/');

//DATABASE DEFINES
define('HN', "192.168.2.100");
define('UN', "eljey");
define('PW', "lkyrie");
define('DN', "dba_datafeed");
define('DT', "mysql");


$files_core = array(
	'router',
	'controller',
	'database',
	'model',
	'view'
	);


//HTML HEAD TAGS
define('DOCTYPE', '<!DOCTYPE html>');
define('TITLE', 'Abibaa.com: Online Shopping from the earth&rsquo;s biggest selection of Music, DVDs, Videos, Electronics, Software, Accessories &amp; more');
define('CHARSET', 'utf-8');
define('LANG', 'en');
define('FAVICON', '');

//GLOBAL META TAGS
$GLOBALS['META'] = array(
	'application-name' => 'Abibaa',
	'author' => 'First Capital',
	'description' => '',
	'generator' => 'First Capital',
	'viewport' => 'width=device-width, initial-scale=1.0',
	'keywords' => ''
);

//DEFAULT THEME
define('THEME','default/');

//GLOBAL STYLESHEETS
$GLOBALS['STYLESHEET'] = array(
	'../bootstrap.css',
	'../font-awesome.css',
	'../jquery-ui.css',
);

//GLOBAL SCRIPTS
$GLOBALS['SCRIPT'] = array(
	'jquery.js',
	'jquery-ui.js',
	'bootstrap.js'
);

//RESOURCE FILES
define('CSS', RS . 'css/');
define('IMG', RS . 'img/');
define('FNT', RS . 'fnt/');
define('JS', RS . 'js/');


$GLOBALS['URLS'] = array(
	'404::index' => 'index::show404'
	);