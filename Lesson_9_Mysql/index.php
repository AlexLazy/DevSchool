<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

$project_root = $_SERVER['DOCUMENT_ROOT'];
$smarty_dir = $project_root.'/smarty/';

require ($smarty_dir . 'date/cfg.php');//настройки
require ($smarty_dir . 'date/functions.php');//функции
require ($smarty_dir . 'date/date.php');//переменные

//Сортировка
if(isset($_GET['sort']) && ($_GET['sort'] === 'title' || $_GET['sort'] === 'seller_name' || $_GET['sort'] === 'price')){
    $ads = parseDB($mysqli, $_GET['sort']);
}else{
    $ads = parseDB($mysqli);
}

//Удаление/сохранение объявления
if (filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) >= -1) {
    ($_GET['id'] == -1) ? delitAds($mysqli) : delitAds($mysqli, $_GET['id']);
}elseif(isset($_POST['submit']) && $_POST['submit'] === 'Отправить') {
    saveAds($mysqli, $post);
}elseif(isset($_POST['submit']) && $_POST['submit'] === 'Сохранить') {
    editAds($mysqli, $post, $_GET['edit']);
}

//Проверка на наличие объявления в базе/присвоение значений переменным полей формы
if (filter_input(INPUT_GET, 'ads', FILTER_VALIDATE_INT) > 0 || filter_input(INPUT_GET, 'edit', FILTER_VALIDATE_INT) > 0) {
    if ((isset($_GET['ads']) && empty($ads[$_GET['ads']])) || (isset($_GET['edit']) && empty($ads[$_GET['edit']]))) {
        echo 'Объявление отсутствует';
        exit;
    } else {
        (isset($_GET['ads'])) ? $fillAds = $ads[$_GET['ads']] : $fillAds = $ads[$_GET['edit']];
        foreach ($fillAds as $key => $value) {
            (isset($value) && !is_array($value)) ? $smarty->assign($key, strip_tags($value)) : $smarty->assign($key, strip_tags($value[0]));
        }
    }
}

$smarty->assign('ads', $ads);
$mysqli->close();
$smarty->display('header.tpl');
$smarty->display('index.tpl');
$smarty->display('footer.tpl');     