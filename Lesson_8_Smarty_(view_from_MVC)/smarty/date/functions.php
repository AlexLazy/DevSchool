<?php

function packAds(&$ads) {
    global $smarty_dir;
    $ads = serialize($ads);
    file_put_contents($smarty_dir . 'date/ads.php', $ads);
}

function unpackAds(&$ads) {
    global $smarty_dir;
    $ads = file_get_contents($smarty_dir . 'date/ads.php');
    $ads = unserialize($ads);
}

//Собирает данные из массива пост в файл ads.php при отправке формы
function saveAds(&$ads) {
    
    if (empty($ads)) {
        if ($_POST['submit'] === 'Отправить' && is_array($_POST) && $_POST != '') {
            $ads[time()] = $_POST;
        }
    } else {
        if ($_POST['submit'] === 'Отправить' && is_array($_POST) && $_POST != '' && end($ads) !== $_POST) {
            $ads[time()] = $_POST;
        } elseif ($_POST['submit'] === 'Сохранить' && is_array($_POST) && $_POST != '') {
            $ads[$_GET['edit']] = $_POST;
        }
    }
    
}

//Удаляет из файлa ads.php объявления
function deletAds(&$ads, $var) {
    global $host;
    
    if (isset($var)) {
        unset($ads[$var]);
    } else {
        unset($ads);
        $ads = [];
    }
    
    packAds($ads);
    header("Location: $host");
    exit; 
}