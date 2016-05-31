<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);

require_once (ABSPATH . 'date/sql.cfg.php');

if(!isset($servername) || !isset($database) || !isset($username)) {
    header('Location: install.php');
}
require_once (ABSPATH . 'date/libs/dbsimple/config.php');
require_once (ABSPATH . 'date/libs/dbsimple/DbSimple/Generic.php');
require_once (ABSPATH . 'smarty/libs/Smarty.class.php');

$smarty = new Smarty();

$smarty->compile_check = true;
$smarty->debugging = false;

$smarty->template_dir = ABSPATH . 'smarty/templates';
$smarty->compile_dir = ABSPATH . 'smarty/templates_c';
$smarty->cache_dir = ABSPATH . 'smarty/cache';
$smarty->config_dir = ABSPATH . 'smarty/configs';

// Подключаемся к БД.
$mysqli = DbSimple_Generic::connect("mysqli://$username:$password@$servername/$database");
if(mysqli_connect_error()) die("Не удалось установить соединение с БД <a href='install.php'>перейти к install</a>");
// Устанавливаем обработчик ошибок.
$mysqli->setErrorHandler('databaseErrorHandler');

//Префиксы для таблиц
define(TABLE_PREFIX, 'ds_');
$mysqli->setIdentPrefix(TABLE_PREFIX); 

// Код обработчика ошибок SQL.
function databaseErrorHandler($message, $info)
{
    // Если использовалась @, ничего не делать.
    if (!error_reporting()) return;
    // Выводим подробную информацию об ошибке.
    echo "SQL Error: $message<br><pre>"; 
    print_r($info);
    echo "</pre>";
    exit();
}

//Автозагрузка классов
spl_autoload_register(function ($class) {
    $file = ABSPATH . 'date/libs/' . $class . '.class.php';
    if(file_exists($file)) include $file;
});