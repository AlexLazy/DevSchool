<?php

//Выводит данные для селектов
function select($table_name, $optgroup=''){
    global $mysqli;
    $result = $mysqli->query("select * from $table_name") or die();
    
    if(empty($optgroup)){
        while($row = $result->fetch_assoc()){
            $res[$row['id']] = $row['name'];
        }
    }else{
        while($row = $result->fetch_assoc()){
            $res[$row[$optgroup]][$row['id']] = $row['name'];
        }
    }
    
    if(isset($res)) {
        return $res;
    }
    $result->close();
}

//Собирает данные таблицы
function parseDB($order='id', $table_name='ds_ads_list'){
    global $mysqli;
    $result = $mysqli->query("select * from $table_name order by $order") or die();
    while ($row = $result->fetch_assoc()) {
        $res[$row['id']] = $row;
    }
    if(isset($res)){
        return $res;
    }
    $result->close();
}

//Сохраняет форму
function saveAds($post, $table_name='ds_ads_list') {
    global $mysqli;
    $stmt = $mysqli->prepare("INSERT INTO $table_name
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
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)") or die();
    $stmt->bind_param('issisiisii',
                        $post['private'],
                        $post['seller_name'],
                        $post['email'],
                        $post['allow_mails'],
                        $post['phone'],
                        $post['location_id'],
                        $post['category_id'],
                        $post['title'],
                        $post['description'],
                        $post['price']) or die();
    $stmt->execute();
    $stmt->close();
    header("Location: /");
    exit; 
}

//Редактирует форму
function editAds($post, $id, $table_name='ds_ads_list') {
    global $mysqli;
    $stmt = $mysqli->prepare("UPDATE $table_name SET
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
                                            WHERE `id` = ?") or die();
    $stmt->bind_param('issisiissii',
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
                        $id) or die();
    
    $stmt->execute();
    $stmt->close();
    header("Location: /");
    exit; 
}

//Удаляет объявление/очищает базу
function delitAds($id='', $table_name='ds_ads_list') {
    global $mysqli;
    if ($id != null) {
        $stmt = $mysqli->prepare("DELETE FROM $table_name WHERE id = ?") or die();
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close(); 
    } else {
        $mysqli->query("DELETE FROM $table_name") or die();
    }
    
    header("Location: /");
    exit; 
}

