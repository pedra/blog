<?php
//Defines for CORE
defined('PHP')      || define('PHP', __DIR__ . '/');
defined('LIB')      || define('LIB', PPHP . 'lib/');

//Auxiliar Functions
include LIB.'start/autoload.php';

//Defines for template
defined('ROOT')     || define('ROOT', dirname($_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_NAME']) . '/');
defined('RPATH')    || define('RPATH', ((strpos(ROOT, 'phar://') === false) ? ROOT : str_replace('phar://', '', dirname(ROOT) . '/')));

//Defines for template to url access
$base = rtrim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']), ' /');
defined('REQST')    || define('REQST', trim(str_replace($base, '', $_SERVER['REQUEST_URI']), ' /'));
defined('URL')      || define('URL', 'http://'.$_SERVER['SERVER_NAME'].$base.'/');

//Configurations
class_alias('Lib\Start\Config', 'o');
o::load(PPHP.'app.ini'); //load config ini file

//Template alias
class_alias('Lib\Start\Html\Doc', 'View');

//Decode route and instantiate controller
$controller = new Lib\Start\Controller(REQST, o::app('controller'));
$controller->solve();

//Template Engine
$out = new Lib\Start\Output($controller->run());
$out->send();//produce and display HTML
