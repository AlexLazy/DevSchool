<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

require_once (ABSPATH . 'date/cfg.php');//настройки
require_once (ABSPATH . 'date/date.php');//переменные

$ads = AdsStore::instance();


   


if($_SERVER['REQUEST_METHOD'] === 'POST')($_POST['private'] == 1)?$ad = new PrivateAds($_POST):$ad = new CompanyAds($_POST);


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['ads'])){
   echo $ads->getAdJSON($_GET['ads']);
}elseif(isset($_GET['sort'])){
   echo $ads->getAdsJSON($_GET['sort']);
}else{
	echo $ads->getAdsJSON();
}

if ($ad) {
    $error = Validator::check($ad);
    if ($error) {
        $ads->errorHandler($ad, $error);
    } else {
        $ad->save();
    }
}