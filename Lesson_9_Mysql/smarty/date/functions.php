<?php

$db = mysql_connect('localhost', 'admin', '123') or die();
mysql_select_db('ds_ads', $db) or die();
mysql_query("SET NAMES utf8");

//Выводит данные для селектов
function select($table_name, $optgroup=''){
    $result = mysql_query("select * from $table_name") or die();

    if(empty($optgroup)){
        while($row = mysql_fetch_assoc($result)){
            $res[$row['id']] = $row['name'];
        }
    }else{
        while($row = mysql_fetch_assoc($result)){
            $res[$row[$optgroup]][$row['id']] = $row['name'];
        }
    }
    
    return $res;
    mysql_free_result($result);
}

//Собирает данные таблицы
function parseDB($table_name='ds_ads_list'){
    $result = mysql_query("select * from $table_name") or die();
    
    while ($row = mysql_fetch_assoc($result)) {
        $res[$row['id']] = $row;
    }

    if(isset($res)){
        return $res;
    }
    mysql_free_result($result);
}

//Сохраняет/редактирует форму
function saveAds($table_name='ds_ads_list') {
    global $host;
    $db = mysql_connect('localhost', 'admin', '123') or die();
    mysql_select_db('ds_ads', $db) or die();
    mysql_query("SET NAMES utf8");
    
    $id = mysql_real_escape_string($_GET['edit']);
    $private = mysql_real_escape_string($_POST['private']);
    $seller_name = mysql_real_escape_string($_POST['seller_name']);
    $email = mysql_real_escape_string($_POST['email']);
    isset($_POST['allow_mails']) ? $allow_mails = 1 : $allow_mails = 0;
    $phone = mysql_real_escape_string($_POST['phone']);
    $location_id = mysql_real_escape_string($_POST['location_id']);
    $category_id = mysql_real_escape_string($_POST['category_id']);
    $title = mysql_real_escape_string($_POST['title']);
    $description = mysql_real_escape_string($_POST['description']);
    $price = mysql_real_escape_string($_POST['price']);
    
    if($_POST['submit'] === 'Отправить'){
        $insert = "INSERT INTO $table_name (`private`, `seller_name`, `email`, `allow_mails`, `phone`, `location_id`, `category_id`, `title`, `description`, `price`)
                VALUES ('$private', '$seller_name', '$email', '$allow_mails', '$phone', '$location_id', '$category_id', '$title', '$description', '$price')";
    }elseif($_POST['submit'] === 'Сохранить'){
        $insert = "UPDATE $table_name SET
        `private` = '$private',
        `seller_name` = '$seller_name',
        `email` = '$email',
        `allow_mails` = '$allow_mails',
        `phone` = '$phone',
        `location_id` = '$location_id',
        `category_id` = '$category_id',
        `title` = '$title',
        `description` = '$description',
        `price` = '$price'
        WHERE `id` = '$id'";
    }
    mysql_query($insert) or die();
    mysql_close();
    header("Location: /");
    exit; 
}

//Удаляет объявление/очищает базу
function delitAds($id, $table_name='ds_ads_list') {
    global $host;
    $db = mysql_connect('localhost', 'admin', '123') or die('Server not found'.mysql_error());
    mysql_select_db('ds_ads', $db) or die();
    mysql_query("SET NAMES utf8");
    
    if (isset($id)) {
        $delit = "DELETE FROM $table_name WHERE ((`id` = '$id'))";
    } else {
        $delit = "DELETE FROM $table_name";
    }
    
    mysql_query($delit) or die();
    mysql_close();
    header("Location: /");
    exit; 
}

$location = select('ds_location');
$category = select('ds_category', 'category');

$ads = parseDB();

mysql_close();