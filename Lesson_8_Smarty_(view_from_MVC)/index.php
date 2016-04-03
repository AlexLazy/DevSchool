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

$smarty->assign('host', $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);

$smarty->assign('private_arr', [
                            1 => 'Частное лицо',
                            0 => 'Компания'
                            ]);
$smarty->assign('private', 1);

$smarty->assign('seller_name');
$smarty->assign('email');

$smarty->assign('allow_mails_arr', [1 => 'Я не хочу получать вопросы по объявлению по e-mail']);
$smarty->assign('allow_mails');

$smarty->assign('phone');

$smarty->assign('location', [
                            '641780'=>'Новосибирск',
                            '641490'=>'Барабинск',
                            '641510'=>'Бердск',
                            '641600'=>'Искитим',
                            '641630'=>'Колывань',
                            '641680'=>'Краснообск'
                            ]);
$smarty->assign('location_id');

$smarty->assign('category', [
                            'Транспорт'=>[
                                '9'   => 'Автомобили с пробегом',
                                '109' => 'Новые автомобили',
                                '14'  => 'Мотоциклы и мототехника',
                                '81'  => 'Грузовики и спецтехника'
                            ],
                            'Недвижимость' => [
                                '24' => 'Квартиры',
                                '23' => 'Комнаты',
                                '25' => 'Дома, дачи, коттеджи'
                            ],
                            'Работа'       => [
                                '111' => 'Вакансии (поиск сотрудников)',
                                '112' => 'Резюме (поиск работы)'
                            ],
                            'Услуги'       => [
                                '114' => 'Предложения услуг',
                                '115' => 'Запросы на услуги'
                            ],
                            'Личные вещи'  => [
                                '27' => 'Одежда, обувь, аксессуары',
                                '29' => 'Детская одежда и обувь',
                                '30' => 'Товары для детей и игрушки'
                            ]
                        ]);
$smarty->assign('category_id');

$smarty->assign('title');
$smarty->assign('description');
$smarty->assign('price', '0');

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
    
    if (isset($var)) {
        unset($ads[$var]);
    } else {
        unset($ads);
        $ads = [];
    }
    
    packAds($ads);
    header("Location: http://xaver.loc");
    exit;
    
}

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


        