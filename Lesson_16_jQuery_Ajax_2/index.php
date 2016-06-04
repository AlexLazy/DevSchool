<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

require_once (ABSPATH . 'date/cfg.php');//настройки
require_once (ABSPATH . 'date/date.php');//переменные


$ads = AdsStore::instance();

$ads->run();