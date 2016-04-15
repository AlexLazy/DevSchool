<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
ini_set('display_errors', 1);
$project_root = $_SERVER['DOCUMENT_ROOT'];

require_once $project_root."/dbsimple/config.php";
require_once $project_root."/dbsimple/DbSimple/Generic.php";

// Подключаемся к БД.
$db = DbSimple_Generic::connect('mysqli://root:123@localhost/eoe');

// Устанавливаем обработчик ошибок.
$db->setErrorHandler('databaseErrorHandler');

$ids = [1, 8, 7];
$result = $db->select("select * from ds_ads_list where id in(?a)",$ids);
var_dump($result);

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