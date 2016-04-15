<?php

//Выводит данные для селектов
function select($table_name, $optgroup=''){
    global $mysqli;

    if(empty($optgroup)){
        $result = $mysqli->selectCol("SELECT id AS ARRAY_KEY, name FROM ?_$table_name");
    }else{
        $arr = $mysqli->select("SELECT id AS ARRAY_KEY, name, parent_id AS PARENT_KEY FROM ?_$table_name");
        foreach($arr as $cat){
            foreach($cat['childNodes'] as $key => $val){
                $result[$cat['name']][$key] = $val['name'];
            }
        }
    }
    if(isset($result)) return $result;
}

//Собирает данные таблицы
function parseDB($order='id', $table_name='ads_list'){
    global $mysqli;
    
    $res = $mysqli->select("SELECT * FROM ?_$table_name ORDER BY $order");
    foreach ($res as $value) {
        $result[$value['id']] = $value;
    }
    if(isset($result)) return $result;
}

//Сохраняет форму
function saveAds($post, $table_name='ads_list') {
    global $mysqli;
    
    $mysqli->query("INSERT INTO ?_$table_name
                                (`private`,
                                `seller_name`,
                                `email`,
                                `allow_mails`,
                                `phone`,
                                `location_id`,
                                `category_id`,
                                `title`,
                                `description`,
                                `price`)
                                VALUES (?,?,?,?,?,?,?,?,?,?)",
                                $post['private'],
                                $post['seller_name'],
                                $post['email'],
                                $post['allow_mails'],
                                $post['phone'],
                                $post['location_id'],
                                $post['category_id'],
                                $post['title'],
                                $post['description'],
                                $post['price']);
    header("Location: /");
    exit; 
}

//Редактирует форму
function editAds($post, $id, $table_name='ads_list') {
    global $mysqli;
    
    $mysqli->query("UPDATE ?_$table_name SET
                                `private` = ?,
                                `seller_name` = ?,
                                `email` = ?,
                                `allow_mails` = ?,
                                `phone` = ?,
                                `location_id` = ?,
                                `category_id` = ?,
                                `title` = ?,
                                `description` = ?,
                                `price` = ?
                                WHERE `id` = ?n",
                                $post['private'],
                                $post['seller_name'],
                                $post['email'],
                                $post['allow_mails'],
                                $post['phone'],
                                $post['location_id'],
                                $post['category_id'],
                                $post['title'],
                                $post['description'],
                                $post['price'],
                                $id);
    header("Location: /");
    exit; 
}

//Удаляет объявление/очищает базу
function deleteAds($id='', $table_name='ads_list') {
    global $mysqli;
    
    if ($id != null) {
        $mysqli->query("DELETE FROM ?_$table_name WHERE id=?d", $id);
    } else {
        $mysqli->query("DELETE FROM ?_$table_name");
    }
    
    header("Location: /");
    exit; 
}

