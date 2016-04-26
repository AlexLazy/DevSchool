<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

require_once (ABSPATH . 'date/cfg.php');//настройки
require_once (ABSPATH . 'date/date.php');//переменные

//Сохранение объявления
if(isset($_POST['submit']) && is_array($_POST) && $_POST['private'] == 1)
{
    $ad = new PrivateAds($_POST);
    if(Validator::check($ad)) $ad->save();
}
elseif(isset($_POST['submit']) && is_array($_POST) && $_POST['private'] == 0)
{
    $ad = new CompanyAds($_POST);
    if(Validator::check($ad)) $ad->save();
}

$ads = AdsStore::instance();
$ads->getAllAdsFromDB();
$ads->prepareForOut();
$ads->display();