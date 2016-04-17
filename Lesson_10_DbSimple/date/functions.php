<?php

//Выводит данные для селектов
function select($table_name, $optgroup='')
{
    global $mysqli, $firePHP;

    if(empty($optgroup))
    {
        $result = $mysqli->selectCol("SELECT id AS ARRAY_KEY, name FROM ?_$table_name");
        $firePHP->fb($result,FirePHP::TRACE);
    }
    else
    {
        $arr = $mysqli->select("SELECT id AS ARRAY_KEY, name, parent_id AS PARENT_KEY FROM ?_$table_name");
        $firePHP->fb($arr,FirePHP::TRACE);
        foreach($arr as $cat)
        {
            foreach($cat['childNodes'] as $key => $val)
            {
                $result[$cat['name']][$key] = $val['name'];
            }
        }
    }
    if(isset($result)) return $result;
}

//Собирает данные таблицы
function parseDB($order='id', $table_name='ads_list')
{
    global $mysqli, $firePHP;
    
    $res = $mysqli->select("SELECT * FROM ?_$table_name ORDER BY $order");
    $firePHP->fb($res,FirePHP::TRACE);
    
    foreach ($res as $value)
    {
        $result[$value['id']] = $value;
    }
    if(isset($result)) return $result;
}

//Сохраняет форму
function saveAds($post, $table_name='ads_list')
{
    global $mysqli;
    $mysqli->query("INSERT INTO ?_$table_name (?#) VALUES(?a)", array_keys($post), array_values($post));
    header("Location: http://" . $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
    exit();
}

//Редактирует форму
function editAds($post, $id, $table_name='ads_list')
{
    global $mysqli;
    
    $mysqli->query("UPDATE ?_$table_name SET ?a WHERE `id` = ?n", $post, $id);
    header("Location: http://" . $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
    exit; 
}

//Удаляет объявление/очищает базу
function deleteAds($id='', $table_name='ads_list')
{
    global $mysqli;
    
    if ($id != null)
    {
        $mysqli->query("DELETE FROM ?_$table_name WHERE id=?d", $id);
    }
    else
    {
        $mysqli->query("DELETE FROM ?_$table_name");
    }
    
    header("Location: http://" . $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
    exit; 
}