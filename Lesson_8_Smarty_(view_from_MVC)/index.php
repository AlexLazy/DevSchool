<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

$project_root = $_SERVER['DOCUMENT_ROOT'];
$smarty_dir = $project_root.'/smarty/';

require ($smarty_dir . 'libs/Smarty.class.php');

$smarty = new Smarty();

$smarty->compile_check = true;
$smarty->debugging = false;

$smarty->template_dir = $smarty_dir . 'templates';
$smarty->compile_dir = $smarty_dir . 'templates_c';
$smarty->cache_dir = $smarty_dir . 'cache';
$smarty->config_dir = $smarty_dir . 'configs';

require ($smarty_dir . 'date/date.php');//переменные
require ($smarty_dir . 'date/functions.php');//функции

if (!file_get_contents($smarty_dir . 'date/ads.php')) {
    echo 'Файл отсутствует';
    exit;
} else {
    
    unpackAds($ads);

    //Удаление/сохранение объявления
    if (filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) >= -1) {
        ($_GET['id'] == -1) ? deletAds($ads) : deletAds($ads, $_GET['id']);
    } elseif (isset($_POST['submit'])) {
        saveAds($ads);
    }
    
    //Проверка на наличие объявления в базе/присвоение значений переменным полей формы
    if (filter_input(INPUT_GET, 'ads', FILTER_VALIDATE_INT) > 0 || filter_input(INPUT_GET, 'edit', FILTER_VALIDATE_INT) > 0) {
        if((isset($_GET['ads']) && empty($ads[$_GET['ads']])) || (isset($_GET['edit']) && empty($ads[$_GET['edit']]))) {
            echo 'Объявление отсутствует';
            exit;
        }else{
            (isset($_GET['ads'])) ? $fillAds = $ads[$_GET['ads']] : $fillAds = $ads[$_GET['edit']];
            foreach ($fillAds as $key => $value) {
                (isset($value)) ? $smarty->assign($key, $value) : '';
            }
        }
    }
    
    $smarty->assign('ads', $ads);
    packAds($ads);
}

$smarty->display('header.tpl');
$smarty->display('index.tpl');
$smarty->display('footer.tpl');


        