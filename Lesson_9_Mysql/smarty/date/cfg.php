<?php

require ($smarty_dir . 'libs/Smarty.class.php');
require ('sql.cfg.php');

$smarty = new Smarty();

$smarty->compile_check = true;
$smarty->debugging = false;

$smarty->template_dir = $smarty_dir . 'templates';
$smarty->compile_dir = $smarty_dir . 'templates_c';
$smarty->cache_dir = $smarty_dir . 'cache';
$smarty->config_dir = $smarty_dir . 'configs';

if(!isset($servername) && !isset($database) && !isset($password)) {
    header('Location: install.php');
}
$mysqli = new mysqli($servername, 'root', $password, $database);
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
$mysqli->set_charset("utf8");