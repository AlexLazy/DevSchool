<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);

require_once 'sql.cfg.php';

if(!isset($servername) || !isset($database) || !isset($username)) {
    header('Location: install.php');
}
require_once $smarty_dir . 'libs/dbsimple/config.php';
require_once $smarty_dir . 'libs/dbsimple/DbSimple/Generic.php';
require_once $smarty_dir . 'libs/Smarty.class.php';

$smarty = new Smarty();

$smarty->compile_check = true;
$smarty->debugging = false;

$smarty->template_dir = $smarty_dir . 'templates';
$smarty->compile_dir = $smarty_dir . 'templates_c';
$smarty->cache_dir = $smarty_dir . 'cache';
$smarty->config_dir = $smarty_dir . 'configs';

// Подключаемся к БД.
$mysqli = DbSimple_Generic::connect("mysqli://$username:$password@$servername/$database");

// Устанавливаем обработчик ошибок.
$mysqli->setErrorHandler('databaseErrorHandler');

define(TABLE_PREFIX, 'ds_'); // с подчерком!
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